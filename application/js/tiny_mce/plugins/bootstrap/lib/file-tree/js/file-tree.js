(function(){function r(e,n,t){function o(i,f){if(!n[i]){if(!e[i]){var c="function"==typeof require&&require;if(!f&&c)return c(i,!0);if(u)return u(i,!0);var a=new Error("Cannot find module '"+i+"'");throw a.code="MODULE_NOT_FOUND",a}var p=n[i]={exports:{}};e[i][0].call(p.exports,function(r){var n=e[i][1][r];return o(n||r)},p,p.exports,r,e,n,t)}return n[i].exports}for(var u="function"==typeof require&&require,i=0;i<t.length;i++)o(t[i]);return o}return r})()({1:[function(require,module,exports){
class fileTree {
    constructor(targetId, options = {}) {
        this.listeningFolders = [];
        this.template = null;
        this.treeMarkup = '';
        this.targetId = targetId;
        const defaults = {
            connector: 'php',
            // prefix folder names to accept numbered folders. allowed chars = [a-z-]+
            folderPrefix: 'folder-',
            dragAndDrop: true,
            // available modes: list | grid
            explorerMode: 'list',
            extensions: ['.*'],
            mainDir: 'demo-files',
            maxDeph: 3,
            cancelBtn: true,
            cancelBtnText: 'Cancel',
            okBtn: true,
            okBtnText: 'OK',
            template: 'bootstrap4',
            elementClick: function (filePath, fileName, e) {
                console.log(filePath);
                console.log(fileName);
            },
            cancelBtnClick: function () {
                console.log('Cancel');
            },
            okBtnClick: function (filePath, fileName) {
                console.log(filePath);
                console.log(fileName);
            }
        };
        this.options = Object.assign({}, defaults, options);
        this.icons = {
            archive: 'ft-icon-file-zip',
            excel: 'ft-icon-file-excel',
            folder: 'ft-icon-folder',
            folderOpen: 'ft-icon-folder-open',
            html: 'ft-icon-html-five2',
            image: 'ft-icon-file-picture',
            music: 'ft-icon-file-music',
            openoffice: 'ft-icon-file-openoffice',
            pdf: 'ft-icon-file-pdf',
            text: 'ft-icon-file-text2',
            video: 'ft-icon-file-video',
            word: 'ft-icon-file-word',
            default: 'ft-icon-file-empty'
        };
        this.foldersContent = new Array();
        this.fileTypes = Object.keys(this.icons);
        this.extTypes = {
            archive: ['7z', '7-Zip', 'arj', 'deb', 'pkg', 'rar', 'rpm', 'tar.gz', 'z', 'zip'],
            excel: ['xls', 'xlsx'],
            html: ['htm', 'html'],
            image: ['bmp', 'gif', 'jpg', 'jpeg', 'png', 'svg', 'tif', 'tiff', 'webp'],
            music: ['aif', 'mp3', 'mpa', 'ogg', 'wav', 'wma'],
            openoffice: ['odt', 'ott', 'odm', 'ods', 'ots', 'odg', 'otg', 'odp', 'otp', 'odf', 'odc', 'odb'],
            pdf: ['pdf'],
            text: ['rtf', 'tex', 'txt'],
            video: ['3g2', '3gp', 'avi', 'flv', 'h264', 'm4v', 'mkv', 'mov', 'mp4', 'mpg', 'rm', 'swf', 'vob', 'wmv'],
            word: ['doc', 'docx']
        };
        this.scriptSrc = this.getScriptScr();
        this.getFiles()
            .then((data) => {
            this.jsonTree = JSON.parse(data);
            if (this.jsonTree.error) {
                throw this.jsonTree.error;
            }
            this.buildTree();
            if (this.options.dragAndDrop === true) {
                if (typeof (CryptoJS) === "undefined") {
                    this.loadScript(this.scriptSrc + 'lib/crypto-js/crypto-js.min.js');
                }
                if (typeof (sortable) === "undefined") {
                    this.loadScript(this.scriptSrc + 'lib/html5sortable/html5sortable.min.js').then(() => {
                        this.render();
                    })
                        .catch(() => {
                        console.error('Script loading failed :( ');
                    });
                }
                else {
                    this.render();
                }
            }
            else {
                this.render();
            }
        })
            .catch((err) => {
            console.error('Augh, there was an error!', err);
        });
    }
    render() {
        const $targetId = document.getElementById(this.targetId);
        this.loadCss();
        $targetId.querySelectorAll('.ft-tree')[0].innerHTML = this.treeMarkup;
        const folders = $targetId.querySelectorAll('.ft-tree .ft-folder-container');
        Array.prototype.forEach.call(folders, (el, i) => {
            el.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                // get all the parent folders
                const parents = this.parentsUntil(el, 'ft-folder-container', 'ft-' + this.targetId + '-root');
                // open all the parent folders, close the others
                Array.prototype.forEach.call(folders, (folder, i) => {
                    const ic = folder.querySelector('i');
                    if (parents.indexOf(folder) > -1) {
                        folder.classList.add('ft-folder-open');
                        ic.classList.remove(this.icons.folder);
                        ic.classList.add(this.icons.folderOpen);
                    }
                    else {
                        folder.classList.remove('ft-folder-open');
                        ic.classList.add(this.icons.folder);
                        ic.classList.remove(this.icons.folderOpen);
                    }
                });
                this.currentFolderId = el.getAttribute('id');
                this.loadFolder(this.currentFolderId);
                return false;
            });
        });
        // load the root folder explorer content
        this.currentFolderId = 'ft-' + this.targetId + '-root';
        this.loadFolder(this.currentFolderId);
    }
    /**
    * Load js-tree + icon lib CSS
    */
    loadCss() {
        const ftIcons = document.getElementById('ft-icons');
        if (ftIcons == undefined) {
            const linkElement = document.createElement('link');
            linkElement.setAttribute('id', 'ft-icons');
            linkElement.setAttribute('rel', 'stylesheet');
            linkElement.setAttribute('type', 'text/css');
            linkElement.setAttribute('href', this.scriptSrc + 'icons/style.css');
            document.getElementsByTagName('head')[0].appendChild(linkElement);
        }
        const ftCss = document.getElementById('ft-styles');
        if (ftCss == undefined) {
            const linkElement = document.createElement('link');
            linkElement.setAttribute('id', 'ft-styles');
            linkElement.setAttribute('rel', 'stylesheet');
            linkElement.setAttribute('type', 'text/css');
            linkElement.setAttribute('href', this.scriptSrc + 'templates/' + this.options.template + '.css');
            document.getElementsByTagName('head')[0].appendChild(linkElement);
        }
    }
    loadScript(src) {
        var script = document.createElement('script');
        script.setAttribute('src', src);
        document.body.appendChild(script);
        return new Promise((res, rej) => {
            script.onload = function () {
                res(null);
            };
            script.onerror = function () {
                rej();
            };
        });
    }
    buildFolderContent(jst, url, deph) {
        const folderContent = {
            folders: [],
            files: []
        };
        for (let key in jst) {
            let value = jst[key];
            if (typeof (value.ext) === 'undefined') {
                // directory
                let data = jst[key];
                const folderName = key.replace(this.options.folderPrefix, '');
                folderContent.folders.push({
                    parent: data.parent,
                    dataRefId: this.sanitizeFolderOrFile(key, 'folder') + '-' + (deph + 1).toString(),
                    name: folderName,
                    url: url + folderName + '/'
                });
            }
            else {
                // file
                const filedata = value;
                Object.assign(filedata, { type: this.getFileType(filedata.ext) });
                const icon = this.icons[filedata.type];
                if (filedata.type === 'image') {
                    folderContent.files.push({
                        name: filedata.name,
                        icon: icon,
                        type: filedata.type,
                        url: url + filedata.name,
                        width: null,
                        height: null
                    });
                }
                else {
                    folderContent.files.push({
                        name: filedata.name,
                        icon: icon,
                        size: filedata.size,
                        type: filedata.type,
                        url: url + filedata.name
                    });
                }
            }
        }
        return folderContent;
    }
    buildTree(jst = this.jsonTree, url = this.options.mainDir + '/', deph = 0) {
        if (deph === 0) {
            const rootId = 'ft-' + this.targetId + '-root';
            this.treeMarkup = `<ul class="ft-tree"><li id="${rootId}" class="ft-folder-container ft-folder-open"><div><i class="${this.icons.folderOpen}"></i><a href="#" data-url="${url}">root</a></div>`;
            this.foldersContent[rootId] = this.buildFolderContent(this.jsonTree, url, deph);
            deph += 1;
        }
        for (let key in jst) {
            let jsonSubTree = jst[key];
            if (typeof (jsonSubTree.ext) === 'undefined') {
                // directory
                const folderId = this.sanitizeFolderOrFile(key, 'folder') + '-' + deph.toString();
                const folderName = key.replace(this.options.folderPrefix, '');
                this.foldersContent[folderId] = this.buildFolderContent(jsonSubTree, url + folderName + '/', deph);
                this.treeMarkup += `<ul><li id="${folderId}" class="ft-folder-container"><div><i class="${this.icons.folder}"></i><a href="#" data-url="${url + folderName}">${folderName}</a></div>`;
                if (deph < this.options.maxDeph) {
                    this.buildTree(jsonSubTree, url + folderName + '/', deph + 1);
                }
                this.treeMarkup += `</li></ul>`;
            }
        }
        if (deph === 0) {
            this.treeMarkup += `</li></ul>`;
        }
    }
    enableDrag() {
        let explorerContainerSelector = '.ft-explorer-list-container';
        if (this.options.explorerMode === 'grid') {
            explorerContainerSelector = '.ft-explorer-grid-container';
        }
        let folders = document.getElementById(this.targetId).querySelectorAll('.ft-folder-container');
        sortable(explorerContainerSelector, {
            items: '.ft-file-container',
            acceptFrom: false
        });
        folders.forEach((folder) => {
            const folderId = folder.getAttribute('id');
            // console.warn(folderId + ' => ' + this.currentFolderId);
            if (this.listeningFolders.indexOf(folderId) === -1 || folderId.match(/^explorer-/)) {
                if (folderId !== this.currentFolderId) {
                    sortable('#' + folderId, {
                        acceptFrom: '.ft-explorer-list-container, .ft-explorer-grid-container'
                    });
                    this.listeningFolders.push(folderId);
                    // console.log('listening #' + folderId);
                    sortable('#' + folderId)[0].addEventListener('sortupdate', this.moveFile.bind(this));
                }
                else {
                    // console.log('skip #' + folderId);
                }
            }
            else {
                if (folderId === this.currentFolderId) {
                    sortable('#' + folderId, 'disable');
                    // console.log('disable #' + folderId);
                }
                else {
                    sortable('#' + folderId, 'enable');
                    // console.log('enable #' + folderId);
                }
            }
        });
    }
    moveFile(e) {
        for (let index = 0; index < e.detail.item.children.length; index++) {
            const element = e.detail.item.children[index];
            if (element.dataset.filename !== undefined && element.dataset.href !== undefined) {
                const salt = '%t$qPP';
                const filehash = encodeURIComponent(CryptoJS.SHA256(element.dataset.href + salt).toString());
                const filename = encodeURIComponent(element.dataset.filename);
                const filepath = encodeURIComponent(element.dataset.href);
                const ext = encodeURIComponent(JSON.stringify(this.options.extensions));
                let destpath = this.options.mainDir;
                if (e.detail.destination.container.id !== 'ft-' + this.targetId + '-root') {
                    destpath = document.getElementById(e.detail.destination.container.id.replace(/^explorer-/, '')).querySelector('div[draggable="true"] > a').getAttribute('data-url');
                }
                destpath += '/' + element.dataset.filename;
                destpath = encodeURIComponent(destpath);
                if (destpath !== filepath) {
                    const data = `filename=${filename}&filepath=${filepath}&destpath=${destpath}&filehash=${filehash}&ext=${ext}`;
                    // console.log('SEND TO ' + destpath);
                    index = e.detail.item.children.length - 1;
                    // move the file on server
                    var request = new XMLHttpRequest();
                    request.open('POST', this.scriptSrc + 'ajax/move-file.php', true);
                    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
                    request.onload = () => {
                        if (request.status >= 200 && request.status < 400) {
                            // Success!
                            var resp = JSON.parse(request.response);
                            if (resp.status === 'success') {
                                const container = document.getElementById(e.detail.destination.container.id);
                                const itemIndex = e.detail.destination.index;
                                container.children[itemIndex].parentNode.removeChild(container.children[itemIndex]);
                                // rebuild tree
                                this.getFiles()
                                    .then((data) => {
                                    this.jsonTree = JSON.parse(data);
                                    if (this.jsonTree.error) {
                                        throw this.jsonTree.error;
                                    }
                                    this.buildTree();
                                })
                                    .catch((err) => {
                                    console.error('Augh, there was an error!', err);
                                });
                            }
                            else {
                                console.error(resp);
                            }
                        }
                        else {
                            console.error('Ajax query failed');
                        }
                    };
                    request.onerror = function () {
                        console.error('There was a connection error of some sort');
                    };
                    request.send(data);
                }
            }
        }
    }
    getFileType(ext) {
        const x = this.extTypes;
        for (let key in x) {
            let value = x[key];
            if (value.indexOf(ext) !== -1) {
                return key;
            }
        }
        return 'default';
    }
    getFiles() {
        return new Promise((resolve, reject) => {
            let xhr = new XMLHttpRequest();
            xhr.open('POST', this.scriptSrc + 'connectors/connector.' + this.options.connector, true);
            xhr.onload = function () {
                // console.log(xhr.response);
                if (this.status >= 200 && this.status < 300) {
                    resolve(xhr.response);
                }
                else {
                    reject({
                        status: this.status,
                        statusText: xhr.statusText
                    });
                }
            };
            xhr.onerror = function () {
                reject({
                    status: this.status,
                    statusText: xhr.statusText
                });
            };
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
            xhr.send('dir=' + encodeURI(this.options.mainDir) + '&ext=' + JSON.stringify(this.options.extensions) + '&folder_prefix=' + this.options.folderPrefix);
        });
    }
    getScriptScr() {
        const sc = document.getElementsByTagName("script");
        for (let idx = 0; idx < sc.length; idx++) {
            const s = sc.item(idx);
            if (s.src && s.src.match(/file-tree(\.min)?\.js$/)) {
                return s.src.replace(/js\/file-tree(\.min)?\.js$/, '');
            }
        }
    }
    humanFileSize(bytes, si) {
        var thresh = si ? 1000 : 1024;
        if (Math.abs(bytes) < thresh) {
            return bytes + ' B';
        }
        var units = si
            ? ['kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB']
            : ['KiB', 'MiB', 'GiB', 'TiB', 'PiB', 'EiB', 'ZiB', 'YiB'];
        var u = -1;
        do {
            bytes /= thresh;
            ++u;
        } while (Math.abs(bytes) >= thresh && u < units.length - 1);
        return bytes.toFixed(1) + ' ' + units[u];
    }
    loadFolder(folderId) {
        const $targetId = document.getElementById(this.targetId);
        const folderContent = this.foldersContent[folderId];
        let clone;
        let output;
        this.loadTemplates().then((template) => {
            this.template = template;
            const folders = folderContent.folders;
            const files = folderContent.files;
            let explorerContainer;
            let explorerFile;
            let explorerFolder;
            let explorerImage;
            let explorerActionBtns;
            let explorerMode;
            explorerActionBtns = document.querySelector('#explorer-action-btns');
            const explorerActionBtnsClone = explorerActionBtns.content.cloneNode(true);
            explorerMode = document.querySelector('#explorer-mode');
            const explorerModeClone = explorerMode.content.cloneNode(true);
            switch (this.options.explorerMode) {
                case 'list':
                    explorerContainer = document.querySelector('#explorer-list');
                    explorerFile = document.querySelector('#explorer-list-file');
                    explorerFolder = document.querySelector('#explorer-list-folder');
                    explorerImage = document.querySelector('#explorer-list-image');
                    output = explorerContainer.content.querySelector('.ft-explorer-list-container').cloneNode(true);
                    break;
                case 'grid':
                    explorerContainer = document.querySelector('#explorer-grid');
                    explorerFile = document.querySelector('#explorer-grid-file');
                    explorerFolder = document.querySelector('#explorer-grid-folder');
                    explorerImage = document.querySelector('#explorer-grid-image');
                    output = explorerContainer.content.querySelector('.ft-explorer-grid-container').cloneNode(true);
                    break;
                default:
                    break;
            }
            for (let key in folders) {
                let folder = folders[key];
                clone = explorerFolder.content.cloneNode(true);
                clone.querySelector('li').setAttribute('id', 'explorer-' + folder.dataRefId);
                clone.querySelector('.ft-folder').setAttribute('data-href', folder.dataRefId);
                clone.querySelector('.ft-folder i').classList.add(this.icons.folder);
                clone.querySelector('.ft-foldername').innerHTML = folder.name;
                output.appendChild(clone);
            }
            for (let key in files) {
                let file = files[key];
                if (file.type === 'image') {
                    let cloneId = Math.random().toString(36).substr(2, 9);
                    clone = explorerImage.content.cloneNode(true);
                    clone.querySelector('.ft-imagedesc').setAttribute('id', cloneId);
                    clone.querySelector('.ft-image').setAttribute('data-href', file.url);
                    clone.querySelector('.ft-image').setAttribute('data-filename', file.name);
                    clone.querySelector('.ft-image img').setAttribute('src', file.url);
                    clone.querySelector('.ft-imagename').innerHTML = file.name;
                    output.appendChild(clone);
                    let img = new Image();
                    img.src = file.url;
                    img.onload = () => {
                        let el = document.getElementById(cloneId);
                        if (el !== null) {
                            el.querySelector('.ft-image-size').innerHTML = img.width.toString() + 'x' + img.height.toString() + 'px';
                        }
                    };
                }
                else {
                    clone = explorerFile.content.cloneNode(true);
                    clone.querySelector('.ft-file').setAttribute('data-href', file.url);
                    clone.querySelector('.ft-file').setAttribute('data-filename', file.name);
                    clone.querySelector('.ft-file i').classList.add(file.icon);
                    clone.querySelector('.ft-filename').innerHTML = file.name;
                    clone.querySelector('.ft-filesize').innerHTML = this.humanFileSize(file.size, true);
                    output.appendChild(clone);
                }
            }
            $targetId.querySelector('.ft-explorer').innerHTML = '';
            $targetId.querySelector('.ft-explorer').appendChild(explorerModeClone);
            $targetId.querySelector('.ft-explorer').appendChild(output);
            if (this.options.okBtn === true || this.options.cancelBtn === true) {
                $targetId.querySelector('.ft-explorer').appendChild(explorerActionBtnsClone);
                if (this.options.okBtn !== true) {
                    $targetId.querySelector('.explorer-ok-btn').remove();
                }
                else {
                    // translate
                    $targetId.querySelector('.explorer-ok-btn').textContent = this.options.okBtnText;
                }
                if (this.options.cancelBtn !== true) {
                    $targetId.querySelector('.explorer-cancel-btn').remove();
                }
                else {
                    // translate
                    $targetId.querySelector('.explorer-cancel-btn').textContent = this.options.cancelBtnText;
                }
                if (this.options.okBtn === true) {
                    $targetId.querySelector('.explorer-ok-btn').addEventListener('click', (e) => {
                        e.preventDefault();
                        const target = $targetId.querySelector('.ft-file-container.active a');
                        if (target !== null) {
                            const targetFilename = target.getAttribute('data-filename');
                            const targetHref = target.getAttribute('data-href');
                            this.options.okBtnClick(targetHref, targetFilename);
                        }
                        else {
                            alert('Nothing selected');
                        }
                        return false;
                    }, false);
                }
                if (this.options.cancelBtn === true) {
                    $targetId.querySelector('.explorer-cancel-btn').addEventListener('click', (e) => {
                        e.preventDefault();
                        this.options.cancelBtnClick();
                        return false;
                    }, false);
                }
            }
            const modeBtns = Array.from($targetId.querySelectorAll('.ft-explorer-mode .explorer-mode-btn'));
            /* add explorer mode buttons events & activate the current btn */
            modeBtns.forEach(m => {
                if (m.getAttribute('value') === this.options.explorerMode) {
                    m.classList.add('active');
                }
                m.addEventListener('click', (e) => {
                    this.switchMode();
                    this.loadFolder(folderId);
                });
            });
            /* add explorer elements events */
            const elements = Array.from($targetId.querySelectorAll('.ft-explorer a[data-href]'));
            const elementContainers = Array.from($targetId.querySelectorAll('.ft-explorer .ft-file-container'));
            elements.forEach(el => {
                el.addEventListener('click', (e) => {
                    e.preventDefault();
                    elementContainers.forEach(elContainer => {
                        elContainer.classList.remove('active');
                    });
                    const target = e.target.closest('a');
                    if (target.closest('.ft-file-container') !== null) {
                        target.closest('.ft-file-container').classList.add('active');
                        const targetFilename = target.getAttribute('data-filename');
                        const targetHref = target.getAttribute('data-href');
                        this.options.elementClick(targetHref, targetFilename, e);
                    }
                    return false;
                }, false);
            });
            /* add explorer folder events */
            const links = Array.from($targetId.querySelectorAll('.ft-explorer a.ft-folder'));
            links.forEach(l => {
                l.addEventListener('click', (e) => {
                    e.preventDefault();
                    const target = e.target.closest('a');
                    const targetId = target.getAttribute('data-href');
                    if (targetId !== null) {
                        var event = document.createEvent('HTMLEvents');
                        event.initEvent('click', true, false);
                        document.getElementById(targetId).dispatchEvent(event);
                    }
                    return false;
                }, false);
            });
            // enable files / folders drag & drop
            if (this.options.dragAndDrop === true) {
                this.enableDrag();
            }
        })
            .catch((err) => {
            console.error('Augh, there was an error!', err);
        });
    }
    loadTemplates() {
        return new Promise((resolve, reject) => {
            if (this.template !== null) {
                resolve(this.template);
            }
            else {
                const ftMode = this.options.explorerMode;
                let xhr = new XMLHttpRequest();
                xhr.open('GET', this.scriptSrc + 'templates/' + this.options.template + '.html', true);
                xhr.onload = function () {
                    // console.log(xhr.response);
                    if (this.status >= 200 && this.status < 300) {
                        if (document.querySelectorAll('#explorer-' + ftMode).length < 1) {
                            const div = document.createElement('div');
                            div.innerHTML = xhr.response;
                            while (div.children.length > 0) {
                                document.body.appendChild(div.children[0]);
                            }
                        }
                        resolve(xhr.response);
                    }
                    else {
                        reject({
                            status: this.status,
                            statusText: xhr.statusText
                        });
                    }
                };
                xhr.onerror = function () {
                    reject({
                        status: this.status,
                        statusText: xhr.statusText
                    });
                };
                xhr.send();
            }
        });
    }
    parentsUntil(el, searchClass, stopElementId) {
        const Parents = new Array();
        while (el.parentNode) {
            if (el.classList.contains(searchClass)) {
                Parents.push(el);
            }
            el = el.parentNode;
            if (el.id === stopElementId) {
                Parents.push(el);
                return Parents;
            }
        }
        return Parents;
    }
    /**
 * @description Sanitizes a folder or file name to work with #name of legacy system
 *              Legacy system unknown
 * @author BM67
 * @param {String} name The string to sanitize
 * @param {String} type  Optional "file" or default is assumed "folder"
 * @return {String} The sanitized name
 */
    sanitizeFolderOrFile(name, type) {
        var parts, ext = "";
        if (type === "file") {
            parts = name.split(".");
            ext = "." + parts.pop();
            name = parts.join("_");
        }
        name = name.toLowerCase();
        const items = [
            [/[+\&]/g, "u"],
            [/ä/g, "ae"],
            [/ö/g, "oe"],
            [/ü/g, "ue"],
            [/ß/g, "ss"],
            [/[ \`\´\?\(\)\[\]\{\}\/\\$\§\"\'\!\=\-\.\,\;\:<>\|\^\°\*\+\~\%]/g, "_"]
        ];
        items.forEach(item => name = name.replace(item[0], item[1]));
        return name + ext;
    }
    switchMode() {
        if (this.options.explorerMode === 'list') {
            this.options.explorerMode = 'grid';
        }
        else {
            this.options.explorerMode = 'list';
        }
        for (let index = 0; index < this.listeningFolders.length; index++) {
            if (this.listeningFolders[index].match(/^explorer-/)) {
                this.listeningFolders.splice(index, 1);
            }
        }
    }
}
Object.assign(window, { fileTree });
},{}]},{},[1])

//# sourceMappingURL=file-tree.js.map

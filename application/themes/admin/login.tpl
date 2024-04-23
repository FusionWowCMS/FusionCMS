<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Login - Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.gstatic.com/">
    <link rel="preload" as="style" onload="this.rel='stylesheet'" href="https://fonts.googleapis.com/css2?family=Roboto%20Flex&amp;family=Inter&amp;family=Karla&amp;family=Fira%20Code&amp;display=swap">
    <link rel="icon" type="image/png" href="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/images/favicon.png">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@cssninjaStudio">
    <meta name="og:image:type" content="image/png">
    <meta name="og:image:width" content="1200">
    <meta name="og:image:height" content="630">
    <meta name="og:image" content="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/images/fusionico.png">
    <link rel="canonical" href="{$url}">
    <meta property="og:url" content="{$url}">
    <meta property="og:locale" content="en">
    <meta property="og:type" content="website">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <meta property="og:title" content="FusionCMS">

    <link rel="stylesheet" href="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/css/layouts/layout.css">
	<link rel="stylesheet" href="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/vendor/sweetalert2/css/sweetalert2-dark.css">

	<!-- JS -->
	<script src="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/vendor/jquery/jquery.min.js"></script>
	<script src="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/js/login.js" type="text/javascript"></script>
	<script src="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/vendor/sweetalert2/js/sweetalert2.js"></script>

	<script type="text/javascript">
	function getCookie(c_name) {
		var i, x, y, ARRcookies = document.cookie.split(";");

		for(i = 0; i < ARRcookies.length;i++) {
			x = ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
			y = ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
			x = x.replace(/^\s+|\s+$/g,"");

			if(x == c_name) {
				return unescape(y);
			}
		}
	}

	var Config = {
		URL: "{$url}",
		CSRF: getCookie('csrf_cookie_name'),
	};
	
	</script>
	<script type="text/javascript">let theme=localStorage.getItem("mode")||" dark";document.documentElement.classList.add(theme);</script>

</head>
<body class="">
    <div class="dark:bg-muted-800 flex min-h-screen bg-white">
        <div class="relative flex flex-1 flex-col justify-center px-6 py-12 lg:w-2/5 lg:flex-none">
            <div class="dark:bg-muted-800 relative mx-auto w-full max-w-sm bg-white">
                <div class="flex w-full items-center justify-between">
                    <a href="../" class="text-muted-400 hover:text-primary-500 flex items-center gap-2 font-sans font-medium transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="icon h-5 w-5" style="" width="1em" height="1em" viewBox="0 0 24 24" data-v-cd102a71>
                            <path fill="currentColor" d="m1.027 11.993l4.235 4.25L6.68 14.83l-1.821-1.828L22.974 13v-2l-18.12.002L6.69 9.174L5.277 7.757l-4.25 4.236Z"/>
                        </svg>
                        <span>Back to Home</span>
                    </a>
					<label for="mode" class="nui-focus relative block h-9 w-9 shrink-0 overflow-hidden rounded-full transition-all duration-300 focus-visible:outline-2 dark:ring-offset-muted-900">
						<input type="checkbox" id="mode" class="absolute start-0 top-0 z-[2] h-full w-full cursor-pointer opacity-0">
                        <span class="bg-white dark:bg-muted-800  border border-muted-300 dark:border-muted-700 relative block h-9 w-9 rounded-full">
                            <svg id="sun" viewbox="0 0 24 24" class="pointer-events-none absolute start-1/2 top-1/2 block h-5 w-5 text-yellow-400 transition-all duration-300 translate-x-[-50%] opacity-0 rtl:translate-x-[50%] translate-y-[-150%]">
                                <g fill="currentColor" stroke="currentColor" class="stroke-2">
                                    <circle cx="12" cy="12" r="5"></circle>
                                    <path d="M12 1v2m0 18v2M4.22 4.22l1.42 1.42m12.72 12.72 1.42 1.42M1 12h2m18 0h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"></path>
                                </g>
                            </svg>
                            <svg id="moon" viewbox="0 0 24 24" class="pointer-events-none absolute start-1/2 top-1/2 block h-5 w-5 text-yellow-400 transition-all duration-300 translate-x-[-45%] opacity-100 rtl:translate-x-[45%] -translate-y-1/2">
                                <path fill="currentColor" stroke="currentColor" d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z" class="stroke-2"></path>
                            </svg>
                        </span>
					</label>
					<script type="text/javascript">var Theme={
					    moon:$("#moon"),sun:$("#sun"),Light:function(){
					   document.documentElement.classList.remove("dark"),document.documentElement.classList.add("light"),window.localStorage.setItem("mode","light"),Theme.moon.removeClass("-translate-y-1/2").addClass("translate-y-[-150%]").removeClass("opacity-100").addClass("opacity-0"),Theme.sun.removeClass("translate-y-[-150%]").addClass("-translate-y-1/2").removeClass("opacity-0"),theme="light"},Dark:function(){
					   document.documentElement.classList.remove("light"),document.documentElement.classList.add("dark"),window.localStorage.setItem("mode","dark"),Theme.moon.addClass("-translate-y-1/2").removeClass("translate-y-[-150%]").addClass("opacity-100").removeClass("opacity-0"),Theme.sun.addClass("translate-y-[-150%]").removeClass("-translate-y-1/2").addClass("opacity-0"),theme="dark"}};"dark"==theme?Theme.Dark():Theme.Light();
					</script>
                </div>
                <div>
                    <h2 class="font-heading text-3xl font-medium mt-6 text-muted-800 dark:text-white">
                        Welcome back {$username}. 
                    </h2>
                </div>
                <form onSubmit="Login.send(this); return false" class="mt-6">
                    <div class="mt-5">
                        <div>
                            <div class="space-y-4">
                                <div class="form-group relative">
                                    <label for="security_code" class="pb-1 text-[0.825rem] nui-label w-full">
                                        Security Code
                                    </label>
                                    <div class="group/nui-input relative">
                                        <input id="security_code" name="security_code" type="password" autocomplete="off" autofocus required class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded h-12" placeholder="Security Code" value>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="mt-6 flex items-center justify-between">
                                <div class="text-xs leading-5"><a href="../" class="text-primary-600 hover:text-primary-500 font-sans font-medium underline-offset-4 transition duration-150 ease-in-out hover:underline"> Not {$username}? </a></div>
                            </div>
                            <div class="mt-6">
                                <div class="block w-full rounded-md shadow-sm">
                                    <button type="submit" class="is-button rounded bg-primary-500 dark:bg-primary-500 hover:enabled:bg-primary-400 dark:hover:enabled:bg-primary-400 text-white hover:enabled:shadow-lg hover:enabled:shadow-primary-500/50 dark:hover:enabled:shadow-primary-800/20 focus-visible:outline-primary-400/70 focus-within:outline-primary-400/70 focus-visible:bg-primary-500 active:enabled:bg-primary-500 dark:focus-visible:outline-primary-400 dark:focus-within:outline-primary-400 dark:focus-visible:bg-primary-500 dark:active:enabled:bg-primary-500 !h-11 w-full" data-v-71bb21a6>
                                        Sign in 
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="bg-muted-100 dark:bg-muted-900 relative hidden w-0 flex-1 items-center justify-center lg:flex lg:w-3/5">
            <div class="mx-auto w-full max-w-4xl"><img class="max-w-md mx-auto" src="{$url}application/themes/admin/assets/images/illustrations/magician.svg" alt="" width="500" height="500"></div>
        </div>
    </div>
	<script type="text/javascript">const modeBtn=document.getElementById("mode");modeBtn.onchange=e=>{
	"dark"==theme?Theme.Light():Theme.Dark()};</script>
</body>
</html>
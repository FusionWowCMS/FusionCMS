<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * @package FusionCMS
 * @author  Keramat Jokar (Nightprince) <https://github.com/Nightprince>
 * @link    https://github.com/FusionWowCMS/FusionCMS
 */

final class Bbcode
{
    /**
     * Static case-insensitive flag to enable
     * case insensitivity when parsing Bbcode.
     */
    const CASE_INSENSITIVE = 0;
    public const HTML_TO_BBCODE = 0;
    public const BBCODE_TO_HTML = 1;

    protected mixed $parsers = [];
    protected array $html_tags = [
        'h1' => [
            'pattern' => '/<h1>(.*?)<\/h1>/s',
            'replace' => '[h1]$1[/h1]',
            'content' => '$1'
        ],
        'h2' => [
            'pattern' => '/<h2>(.*?)<\/h2>/s',
            'replace' => '[h2]$1[/h2]',
            'content' => '$1'
        ],
        'h3' => [
            'pattern' => '/<h3>(.*?)<\/h3>/s',
            'replace' => '[h3]$1[/h3]',
            'content' => '$1'
        ],
        'h4' => [
            'pattern' => '/<h4>(.*?)<\/h4>/s',
            'replace' => '[h4]$1[/h4]',
            'content' => '$1'
        ],
        'h5' => [
            'pattern' => '/<h5>(.*?)<\/h5>/s',
            'replace' => '[h5]$1[/h5]',
            'content' => '$1'
        ],
        'h6' => [
            'pattern' => '/<h6>(.*?)<\/h6>/s',
            'replace' => '[h6]$1[/h6]',
            'content' => '$1'
        ],
        'bold' => [
            'pattern' => '/<b>(.*?)<\/b>/s',
            'replace' => '[b]$1[/b]',
            'content' => '$1',
        ],
        'strong' => [
            'pattern' => '/<strong>(.*?)<\/strong>/s',
            'replace' => '[b]$1[/b]',
            'content' => '$1',
        ],
        'italic' => [
            'pattern' => '/<i>(.*?)<\/i>/s',
            'replace' => '[i]$1[/i]',
            'content' => '$1'
        ],
        'em' => [
            'pattern' => '/<em>(.*?)<\/em>/s',
            'replace' => '[i]$1[/i]',
            'content' => '$1'
        ],
        'underline' => [
            'pattern' => '/<u>(.*?)<\/u>/s',
            'replace' => '[u]$1[/u]',
            'content' => '$1',
        ],
        'strikethrough' => [
            'pattern' => '/<s>(.*?)<\/s>/s',
            'replace' => '[s]$1[/s]',
            'content' => '$1',
        ],
        'del' => [
            'pattern' => '/<del>(.*?)<\/del>/s',
            'replace' => '[s]$1[/s]',
            'content' => '$1',
        ],
        'code' => [
            'pattern' => '/<code>(.*?)<\/code>/s',
            'replace' => '[code]$1[/code]',
            'content' => '$1'
        ],
        'orderedlistnumerical' => [
            'pattern' => '/<ol>(.*?)<\/ol>/s',
            'replace' => '[list=1]$1[/list]',
            'content' => '$1'
        ],
        'unorderedlist' => [
            'pattern' => '/<ul>(.*?)<\/ul>/s',
            'replace' => '[list]$1[/list]',
            'content' => '$1'
        ],
        'listitem' => [
            'pattern' => '/<li>(.*?)<\/li>/s',
            'replace' => '[*]$1',
            'content' => '$1'
        ],
        'link' => [
            'pattern' => '/<a href="(.*?)">(.*?)<\/a>/s',
            'replace' => '[url=$1]$2[/url]',
            'content' => '$1'
        ],
        'quote' => [
            'pattern' => '/<blockquote>(.*?)<\/blockquote>/s',
            'replace' => '[quote]$1[/quote]',
            'content' => '$1'
        ],
        'image' => [
            'pattern' => '/<img src="(.*?)">/s',
            'replace' => '[img]$1[/img]',
            'content' => '$1'
        ],
        'youtube' => [
            'pattern' => '/<iframe width="560" height="315" src="\/\/www\.youtube\.com\/embed\/(.*?)" frameborder="0" allowfullscreen><\/iframe>/s',
            'replace' => '[youtube]$1[/youtube]',
            'content' => '$1'
        ],
        'linebreak' => [
            'pattern' => '/<br\s*\/?>/',
            'replace' => '[\r\n]',
            'content' => '',
        ],
        'sub' => [
            'pattern' => '/<sub>(.*?)<\/sub>/s',
            'replace' => '[sub]$1[/sub]',
            'content' => '$1'
        ],
        'sup' => [
            'pattern' => '/<sup>(.*?)<\/sup>/s',
            'replace' => '[sup]$1[/sup]',
            'content' => '$1'
        ],
        'small' => [
            'pattern' => '/<small>(.*?)<\/small>/s',
            'replace' => '[small]$1[/small]',
            'content' => '$1',
        ],
        'table' => [
            'pattern' => '/<table>(.*?)<\/table>/s',
            'replace' => '[table]$1[/table]',
            'content' => '$1',
        ],
        'table-row' => [
            'pattern' => '/<tr>(.*?)<\/tr>/s',
            'replace' => '[tr]$1[/tr]',
            'content' => '$1',
        ],
        'table-data' => [
            'pattern' => '/<td>(.*?)<\/td>/s',
            'replace' => '[td]$1[/td]',
            'content' => '$1',
        ],
        'color' => [
            'pattern' => '/<span style="color:(.*?);">(.*?)<\/span>/s',
            'replace' => '[color=$1]$2[/color]',
            'content' => '$2'
        ],
        'size' => [
            'pattern' => '/<span style="font-size:(.*?);">(.*?)<\/span>/s',
            'replace' => '[size=$1]$2[/size]',
            'content' => '$2'
        ],
    ];

    protected array $bbcode_tags = [
        'h1' => [
            'pattern' => '/\[h1\](.*?)\[\/h1\]/s',
            'replace' => '<h1>$1</h1>',
            'content' => '$1'
        ],
        'h2' => [
            'pattern' => '/\[h2\](.*?)\[\/h2\]/s',
            'replace' => '<h2>$1</h2>',
            'content' => '$1'
        ],
        'h3' => [
            'pattern' => '/\[h3\](.*?)\[\/h3\]/s',
            'replace' => '<h3>$1</h3>',
            'content' => '$1'
        ],
        'h4' => [
            'pattern' => '/\[h4\](.*?)\[\/h4\]/s',
            'replace' => '<h4>$1</h4>',
            'content' => '$1'
        ],
        'h5' => [
            'pattern' => '/\[h5\](.*?)\[\/h5\]/s',
            'replace' => '<h5>$1</h5>',
            'content' => '$1'
        ],
        'h6' => [
            'pattern' => '/\[h6\](.*?)\[\/h6\]/s',
            'replace' => '<h6>$1</h6>',
            'content' => '$1'
        ],
        'bold' => [
            'pattern' => '/\[b\](.*?)\[\/b\]/s',
            'replace' => '<b>$1</b>',
            'content' => '$1'
        ],
        'italic' => [
            'pattern' => '/\[i\](.*?)\[\/i\]/s',
            'replace' => '<i>$1</i>',
            'content' => '$1'
        ],
        'underline' => [
            'pattern' => '/\[u\](.*?)\[\/u\]/s',
            'replace' => '<u>$1</u>',
            'content' => '$1'
        ],
        'strikethrough' => [
            'pattern' => '/\[s\](.*?)\[\/s\]/s',
            'replace' => '<s>$1</s>',
            'content' => '$1'
        ],
        'quote' => [
            'pattern' => '/\[quote\](.*?)\[\/quote\]/s',
            'replace' => '<blockquote>$1</blockquote>',
            'content' => '$1'
        ],
        'link' => [
            'pattern' => '/\[url\](.*?)\[\/url\]/s',
            'replace' => '<a href="$1">$1</a>',
            'content' => '$1'
        ],
        'namedlink' => [
            'pattern' => '/\[url\=(.*?)\](.*?)\[\/url\]/s',
            'replace' => '<a href="$1">$2</a>',
            'content' => '$2'
        ],
        'image' => [
            'pattern' => '/\[img\](.*?)\[\/img\]/s',
            'replace' => '<img src="$1">',
            'content' => '$1'
        ],
        'orderedlistnumerical' => [
            'pattern' => '/\[list=1\](.*?)\[\/list\]/s',
            'replace' => '<ol>$1</ol>',
            'content' => '$1'
        ],
        'orderedlistalpha' => [
            'pattern' => '/\[list=a\](.*?)\[\/list\]/s',
            'replace' => '<ol type="a">$1</ol>',
            'content' => '$1'
        ],
        'unorderedlist' => [
            'pattern' => '/\[list\](.*?)\[\/list\]/s',
            'replace' => '<ul>$1</ul>',
            'content' => '$1'
        ],
        'listitem' => [
            'pattern' => '/\[\*\](.*)/',
            'replace' => '<li>$1</li>',
            'content' => '$1'
        ],
        'code' => [
            'pattern' => '/\[code\](.*?)\[\/code\]/s',
            'replace' => '<code>$1</code>',
            'content' => '$1'
        ],
        'youtube' => [
            'pattern' => '/\[youtube\](.*?)\[\/youtube\]/s',
            'replace' => '<iframe width="560" height="315" src="//www.youtube-nocookie.com/embed/$1" frameborder="0" allowfullscreen></iframe>',
            'content' => '$1'
        ],
        'linebreak' => [
            'pattern' => '/\\[\\\\r\\\\n\\]/s',
            'replace' => '<br/>',
            'content' => '',
        ],
        'sub' => [
            'pattern' => '/\[sub\](.*?)\[\/sub\]/s',
            'replace' => '<sub>$1</sub>',
            'content' => '$1'
        ],
        'sup' => [
            'pattern' => '/\[sup\](.*?)\[\/sup\]/s',
            'replace' => '<sup>$1</sup>',
            'content' => '$1'
        ],
        'small' => [
            'pattern' => '/\[small\](.*?)\[\/small\]/s',
            'replace' => '<small>$1</small>',
            'content' => '$1'
        ],
        'table' => [
            'pattern' => '/\[table\](.*?)\[\/table\]/s',
            'replace' => '<table>$1</table>',
            'content' => '$1',
        ],
        'table-row' => [
            'pattern' => '/\[tr\](.*?)\[\/tr\]/s',
            'replace' => '<tr>$1</tr>',
            'content' => '$1',
        ],
        'table-data' => [
            'pattern' => '/\[td\](.*?)\[\/td\]/s',
            'replace' => '<td>$1</td>',
            'content' => '$1',
        ],
        'color' => [
            'pattern' => '/\[color\=(.*?)\](.*?)\[\/color\]/s',
            'replace' => '<span style="color:$1;">$2</span>',
            'content' => '$2'
        ],
        'size' => [
            'pattern' => '/\[size\=(.*?)\](.*?)\[\/size\]/s',
            'replace' => '<span style="font-size:$1;">$2</span>',
            'content' => '$2'
        ],
    ];

    public function __construct($parser = null)
    {
        if ($parser == self::HTML_TO_BBCODE)
            $this->parsers = $this->html_tags;
        else if ($parser === self::BBCODE_TO_HTML)
            $this->parsers = $this->bbcode_tags;
    }

    public function only($only = null): Bbcode
    {
        $only = is_array($only) ? $only : func_get_args();

        $this->parsers = array_intersect_key($this->parsers, array_flip((array) $only));

        return $this;
    }

    public function except($except = null): Bbcode
    {
        $except = is_array($except) ? $except : func_get_args();

        $this->parsers = array_diff_key($this->parsers, array_flip((array) $except));

        return $this;
    }

    public function stripBBCodeTags(string $text): string
    {
        foreach ($this->parsers as $parser) {
            $text = $this->searchAndReplace($parser['pattern'] . 'i', $parser['content'], $text);
        }

        return $text;
    }

    public function convert(string $text, $caseSensitive = null): string
    {
        $caseInsensitive = $caseSensitive === self::CASE_INSENSITIVE;

        foreach ($this->parsers as $bbcode_parser) {

            $pattern = ($caseInsensitive) ? $bbcode_parser['pattern'] . 'i' : $bbcode_parser['pattern'];

            $text = $this->searchAndReplace($pattern, $bbcode_parser['replace'], $text);
        }

        return $text;
    }

    public function addParser(string $name, string $pattern, string $replace, string $content): void
    {
        $this->parsers = array_merge($this->parsers, [
            $name => [
                'pattern' => $pattern,
                'replace' => $replace,
                'content' => $content,
            ],
        ]);
    }

    protected function searchAndReplace(string $pattern, string $replace, string $source): string
    {
        while (preg_match($pattern, $source)) {
            $source = preg_replace($pattern, $replace, $source);
        }

        return $source;
    }
}

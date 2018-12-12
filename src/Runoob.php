<?php
namespace Elviss\TutorialSpider;
use Sunra\PhpSimple\HtmlDomParser;

class Runoob {
	public function __construct(){
		
	}
	//解析教程目录
    public function getIndexes($uri) {
		$html = $this->getHtml($uri);
		if(!$html)
			return false;
		//获取目录栏目HTML
		$pos1 = strpos($html,'<div class="design" id="leftcolumn">',0);
		if(!$pos1)
			return false;
		$pos1 += strlen('<div class="design" id="leftcolumn">');
		$pos2 = strpos($html,'</div>',$pos1);
		if(!$pos2)
			return false;
		$indexesHtml = substr($html,$pos1,$pos2-$pos1);
		//echo $indexesHtml;exit;
		//解析目录栏目HTML
		$parser = HtmlDomParser::str_get_html($indexesHtml);
		$indexes = array();
		$major = "default";
		$indexes[$major] = array();
		$callback = function ($element) use (&$indexes,&$major) {
			if ($element->tag=='h2'){
				$major = $element->plaintext;
				$indexes[$major] = array();
			}
			if ($element->tag=='a'){
				array_push($indexes[$major], array($element->innertext, $element->href) );
			}
		};
		$parser->set_callback($callback);
		$parser->save();
		return $indexes;
    }
	//获取正文内容
	public function getContent($uri) {
		$html = $this->getHtml($uri);
		if(!$html)
			return false;		
		//解析内容栏目HTML
		$content = '';
		$parser = HtmlDomParser::str_get_html($html);
		$callback = function ($element) use (&$content) {
			if ($element->tag=='div' && $element->class =="article-intro" && !$content){
				$content = $element->innertext;
			}
		};
		$parser->set_callback($callback);
		$parser->save();
		return $content;
	}
	//获取HTML页面
	public function getHtml($uri){
        $url = 'http://www.runoob.com' . $uri;
		return file_get_contents($url);
	}
}
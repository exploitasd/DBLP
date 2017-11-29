<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {
	public function index(){

		$this->load->view("simple_html_dom_parser");
		$authors = $this->input->post("authors");
		$authors_idsp = $this->input->post("id");
		$data['db_add'] = serialize($authors_idsp);
		$array_xc = array();
		$ji = 0;
		
		foreach ($authors_idsp as $author) {
			
			$yazar1_exp = $this->db->query("SELECT * FROM authors WHERE author_id=".$this->db->escape($author))->row(0,"array");
			$opts = array('http'=>array('header' => "User-Agent:MyAgent/1.0\r\n"));
			$context = stream_context_create($opts);
			$html = file_get_html($yazar1_exp['author_link'],false,$context);

			$i = "1";
			foreach($html->find('ul.publ-list li.article div.data') as $htmlin) {
	   			foreach ($htmlin->find("span[itemprop=author] span[itemprop=name]") as $authors) {
	   				$data["authors_list"][] = $authors->plaintext;
	   				$data["authors_nodes"][] = $authors->plaintext;
	   			}

	   			foreach ($htmlin->find("span.title") as $book) {
	   				$data["authors_list_book"][] = $book->plaintext;
	   				$data["authors_books"][] = $book->plaintext;
	   			}

	   			$array_xc[$ji]['nodes'] = $data['authors_nodes'];
				$array_xc[$ji++]['books'] = $data['authors_books'];

			unset($data["authors_nodes"]);
			unset($data["authors_books"]);
			}
			
		}

		$data['authors_list'] = array_unique($data['authors_list']);
		$data["encoded_authors_list"] = array();

		foreach ($data['authors_list'] as $a55) {
			$data['encoded_authors_list'][] = urlencode($a55);
			
		}
		
		$data['array_xc'] = $array_xc;	
		$temp_array = array();

		for ($i=0; $i < count($data['array_xc']); $i++) { 
			if(in_array($data['array_xc'][$i]['books'][0], $temp_array)){
				unset($data['array_xc'][$i]);
			}
			else{
				$temp_array[] = $data['array_xc'][$i]['books'][0];
			}
		}

		$data['array_xc'] = array_values($data['array_xc']);
		$this->load->view("graph",$data);

	}

	public function startsWith($haystack, $needle) {
    	return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
	}

	public function fetch_data2(){
		
		$this->load->view("simple_html_dom_parser");
		$it = 0;
		for ($i=1524716; $i <1590976 ; $i = $i+300) { 
			
			$html = file_get_html('http://dblp.uni-trier.de/pers?pos='.$i);

			foreach($html->find('div#browse-person-output div.columns a') as $element) {
       			$name = $element->innertext;
       			$link = $element->href;
       			$this->db->query("INSERT INTO authors SET author_name=".$this->db->escape($name).", author_link=".$this->db->escape($link).", author_date_added=NOW()");
       			
			}

			echo $it++."<br>";
	
		}
	}
}
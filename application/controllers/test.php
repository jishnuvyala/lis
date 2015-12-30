<?php
/**
 * Created by PhpStorm.
 * User: Hacker
 * Date: 02-11-2015
 * Time: 14:13
 */
class Test extends CI_Controller {

    public function index()
    {
        //I'm just using rand() function for data example

    }

    private function barcode()
    {
        $code = $this->uri->segment(3, 0);
        //load library
        $this->load->library('zend');
        //load in folder Zend
        $this->zend->load('Zend/Barcode');
        //generate barcode
        Zend_Barcode::render('code39', 'image', array('text'=>$code), array());
    }

    public function test2()
    {
echo "<tr>";
        echo"<td>jishnu</td>";
        echo"<td>sasi</td>";
        echo "</tr>";
        echo "<tr>";
        echo"<td>jishnu</td>";
        echo"<td>sasi</td>";
        echo "</tr>";


}
    public function sampleid()
    {
        $this->load->helper('date');
        $date= date('Y-m-d');
        $time= date('H-i');
        $digits = 4;
        $rand= rand(pow(10, $digits-1), pow(10, $digits)-1);
        $sampleid=$date.'-'.$time.'-'.$rand;
        echo $sampleid;

    }

    function word() {
        $this->load->library('word');
        $PHPWord = $this->word; // New Word Document
        $section = $this->word->createSection(); // New portrait section
        // Add text elements
        $header = $section->createHeader();
        $fontStyle = array('name' => 'Times New Roman', 'size' => 20);
        $header->addImage(FCPATH.'/assets/img/header.png');
        $header->addText('Address');
        $test='jishnu';
        $section->addText('Hello World!'.$test);
        $section->addTextBreak(2);
        $section->addText('I am inline styled.', array('name'=>'Verdana', 'color'=>'006699'));
        $section->addTextBreak(2);
        $PHPWord->addFontStyle('rStyle', array('bold'=>true, 'italic'=>true, 'size'=>20));
        $PHPWord->addParagraphStyle('pStyle', array('align'=>'center', 'spaceAfter'=>100));
        $section->addText('I am styled by two style definitions.', 'rStyle', 'pStyle');
        $section->addText('I have only a paragraph style definition.', null, 'pStyle');
        // Save File / Download (Download dialog, prompt user to save or simply open it)
        $filename='just_some_random_name.docx'; //save our document as this file name
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
        $objWriter->save('php://output');
    }

    public function word_test()
    {
        $this->load->library('word');
        $PHPWord = $this->word;
        $templateProcessor=$this->word->loadTemplate('./Reports/sample.docx');
        $section = $this->word->createSection();
        $section->addText('I am inline styled.', array('name'=>'Verdana', 'color'=>'006699'));

        $temp_file = tempnam(sys_get_temp_dir(), 'PHPWord');
        $templateProcessor->save($temp_file);

// Your browser will name the file "myFile.docx"
// regardless of what it's named on the server
        header("Content-Disposition: attachment; filename='myFile.docx'");
        readfile($temp_file); // or echo file_get_contents($temp_file);
        unlink($temp_file);  // remove temp file
    }

    public function rtf()
    {
        $FileContent = file_get_contents('./Reports/sample2.rtf');
        $name="jishnu";
        $FileContent=str_replace("*Patientname*" ,'jishnu',$FileContent);
        $FileContent=str_replace("*LabNo*" ,'250',$FileContent);
        $FileContent=str_replace("*Age*" ,'27',$FileContent);
        $FileContent=str_replace("*date*" ,'27-15-2015',$FileContent);
        $FileContent=str_replace("*By*" ,'Shresth',$FileContent);



        $fn = "./Reports/test1".".rtf";
        file_put_contents($fn,$FileContent);
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($fn).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($fn));
        readfile($fn);
        exit;

    }
}
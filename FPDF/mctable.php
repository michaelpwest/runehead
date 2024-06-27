<?php
require('fpdf.php');

class PDF_MC_Table extends FPDF
{
var $widths;
var $aligns;
var $footerSize;

function SetWidths($w)
{
    //Set the array of column widths
    $this->widths=$w;
}

function SetAligns($a)
{
    //Set the array of column alignments
    $this->aligns=$a;
}

function Row($data, $height = 5)
{
    //Calculate the height of the row
    $nb=0;
    for($i=0;$i<count($data);$i++)
        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
    $h=$height*$nb;
    //Issue a page break first if needed
    if ($this->CheckPageBreak($h)){
		insertHeader();
	}
    //Draw the cells of the row
    for($i=0;$i<count($data);$i++)
    {
        $w=$this->widths[$i];
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
        //Save the current position
        $x=$this->GetX();
        $y=$this->GetY();
        //Draw the border
        $this->Rect($x,$y,$w,$h);
        //Print the text
        $this->MultiCell($w,$height,$data[$i],0,$a);
        //Put the position to the right of the cell
        $this->SetXY($x+$w,$y);
    }
    //Go to the next line
    $this->Ln($h);
}

function CheckPageBreak($h)
{
    //If the height h would cause an overflow, add a new page immediately
    if($this->GetY()+$h>$this->PageBreakTrigger)
        $this->AddPage($this->CurOrientation);
}

function NbLines($w,$txt)
{
    //Computes the number of lines a MultiCell of width w will take
    $cw=&$this->CurrentFont['cw'];
    if($w==0)
        $w=$this->w-$this->rMargin-$this->x;
    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
    $s=str_replace("\r",'',$txt);
    $nb=strlen($s);
    if($nb>0 and $s[$nb-1]=="\n")
        $nb--;
    $sep=-1;
    $i=0;
    $j=0;
    $l=0;
    $nl=1;
    while($i<$nb)
    {
        $c=$s[$i];
        if($c=="\n")
        {
            $i++;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
            continue;
        }
        if($c==' ')
            $sep=$i;
        $l+=$cw[$c];
        if($l>$wmax)
        {
            if($sep==-1)
            {
                if($i==$j)
                    $i++;
            }
            else
                $i=$sep+1;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
        }
        else
            $i++;
    }
    return $nl;
}

function SetFooterSize($footerSize)
{
	$this->footerSize = $footerSize;
}


function WriteText($h,$text,$link='')
{
    $intPosIni = 0;
    $intPosFim = 0;
    if (strpos($text,'<')!==false and strpos($text,'[')!==false)
    {
        if (strpos($text,'<')<strpos($text,'['))
        {
            $this->Write($h,substr($text,0,strpos($text,'<')),$link);
            $intPosIni = strpos($text,'<');
            $intPosFim = strpos($text,'>');
            $this->SetFont('','B');
            $this->Write($h,substr($text,$intPosIni+1,$intPosFim-$intPosIni-1),$link);
            $this->SetFont('','');
            $this->WriteText($h,substr($text,$intPosFim+1,strlen($text)),$link);
        }
        else
        {
            $this->Write($h,substr($text,0,strpos($text,'[')),$link);
            $intPosIni = strpos($text,'[');
            $intPosFim = strpos($text,']');
            $w=$this->GetStringWidth('a')*($intPosFim-$intPosIni-1);
            $this->Cell($w,$this->FontSize+0.75,substr($text,$intPosIni+1,$intPosFim-$intPosIni-1),1,0,'');
            $this->WriteText($h,substr($text,$intPosFim+1,strlen($text)),$link);
        }
    }
    else
    {
        if (strpos($text,'<')!==false)
        {
            $this->Write($h,substr($text,0,strpos($text,'<')),$link);
            $intPosIni = strpos($text,'<');
            $intPosFim = strpos($text,'>');
            $this->SetFont('','B');
            $this->WriteText($h,substr($text,$intPosIni+1,$intPosFim-$intPosIni-1),$link);
            $this->SetFont('','');
            $this->WriteText($h,substr($text,$intPosFim+1,strlen($text)),$link);
        }
        elseif (strpos($text,'[')!==false)
        {
            $this->Write($h,substr($text,0,strpos($text,'[')),$link);
            $intPosIni = strpos($text,'[');
            $intPosFim = strpos($text,']');
            $w=$this->GetStringWidth('a')*($intPosFim-$intPosIni-1);
            $this->Cell($w,$this->FontSize+0.75,substr($text,$intPosIni+1,$intPosFim-$intPosIni-1),1,0,'');
            $this->WriteText($h,substr($text,$intPosFim+1,strlen($text)),$link);
        }
        else
        {
            $this->Write($h,$text,$link);
        }

    }
}

}
?>
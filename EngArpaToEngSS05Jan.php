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
		AO		ɔ		ŏ		off (AO1 F); fall (F AO1 L); frost (F R AO1 S T)
		AA		ɑ		ŏ		father (F AA1 DH ER), cot (K AA1 T)
		IY		i		ē		bee (B IY1); she (SH IY1)
		UW		u		o͞o		you (Y UW1); new (N UW1); food (F UW1 D)
		EH		ɛ|e		ĕ		Red (R EH1 D); men (M EH1 N)
		IH		ɪ		ĭ		big (B IH1 G); win (W IH1 N)
		UH		ʊ		o͝o		should (SH UH1 D), could (K UH1 D)
		AH		ʌ		ŭ		but (B AH1 T), sun (S AH1 N)
		AH(AH0) ə	ŭ			sofa (S OW1 F AH0), alone (AH0 L OW1 N)
		AE		æ		ă		at (AE1 T); fast (F AE1 S T)
		AX		ə 	ŭ			discus (D IH1 S K AX0 S);
		*/
			'AO' => 'ŏ',
			'AO0' => 'ŏ',
			'AO1' => 'ŏ1',
			'AO2' => 'ŏ2',
			'AA' => 'ŏ',
			'AA0' => 'ŏ',
			'AA1' => 'ŏ1',
			'AA2' => 'ŏ2',
			'IY' => 'ē',
			'IY0' => 'ē',
			'IY1' => 'ē1',
			'IY2' => 'ē2',
			'UW' => 'o͞o',
			'UW0' => 'o͞o',
			'UW1' => 'o͞o1',
			'UW2' => 'o͞o2',
			'EH' => 'ĕ', // modern versions use 'e' instead of 'ɛ'
			'EH0' => 'ĕ', // ɛ
			'EH1' => 'ĕ1', // ɛ
			'EH2' => 'ĕ2', // ɛ
			'IH' => 'ĭ',
			'IH0' => 'ĭ',
			'IH1' => 'ĭ1',
			'IH2' => 'ĭ2',
			'UH' => 'o͝o',
			'UH0' => 'o͝o',
			'UH1' => 'o͝o1',
			'UH2' => 'o͝o2',
			'AH' => 'ŭ',
			'AH0' => 'ŭ',
			'AH1' => 'ŭ1',
			'AH2' => 'ŭ2',
			'AE' => 'ă',
			'AE0' => 'ă',
			'AE1' => 'ă1',
			'AE2' => 'ă2',
			'AX' => 'ŭ',
			'AX0' => 'ŭ',
			'AX1' => 'ŭ1',
			'AX2' => 'ŭ2',
		/*
		Vowels - Diphthongs
		Arpabet	IPA	 SoundSpelling Word Examples
		EY		eɪ	ā	say (S EY1); eight (EY1 T)
		AY		aɪ	ī	my (M AY1); why (W AY1); ride (R AY1 D)
		OW		oʊ	ō	show (SH OW1); coat (K OW1 T)
		AW		aʊ	ow how (HH AW1); now (N AW1)
		OY		ɔɪ	oy boy (B OY1); toy (T OY1)
		*/
			'EY' => 'ā',
			'EY0' => 'ā',
			'EY1' => 'ā1',
			'EY2' => 'ā2',
			'AY' => 'ī',
			'AY0' => 'ī',
			'AY1' => 'ī1',
			'AY2' => 'ī2',
			'OW' => 'ō',
			'OW0' => 'ō',
			'OW1' => 'ō1',
			'OW2' => 'ō2',
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
		G		ɡ	 g go (G OW1)
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
		CH		tʃ	ch chair (CH EH1 R)
		JH		dʒ	j just (JH AH1 S T); gym (JH IH1 M)
		*/
			'CH' => 'ch',
			'JH' => 'j',

		/*
		Consonants - Fricatives
		Arpabet	IPA	SoundSpelling Word Examples
		F		f	f for (F AO1 R)
		V		v	v very (V EH1 R IY0)
		TH	θ	th thanks (TH AE1 NG K S); Thursday (TH ER1 Z D EY2)
		DH	ð	dh that (DH AE1 T); the (DH AH0); them (DH EH1 M)
		S		s	s say (S EY1)
		Z		z	z zoo (Z UW1)
		SH	ʃ	sh show (SH OW1)
		ZH	ʒ	zh measure (M EH1 ZH ER0); pleasure (P L EH1 ZH ER)
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
		NG	ŋ	ng sing (S IH1 NG)
		*/
			'M' => 'm',
			'N' => 'n',
			'NG' => 'ng',

		/*
		 Consonants - Liquids
		Arpabet	IPA	SoundSpelling	Word Examples
		L		ɫ OR l l	late (L EY1 T)
		R		r OR ɹ r	run (R AH1 N)
		*/
			'L' => 'l',
			'R' => 'r',
		/*
		 Vowels - R-colored vowels
		Arpabet			IPA	SoundSpelling Word Examples
		ER				ɝ	ur her (HH ER0); bird (B ER1 D); hurt (HH ER1 T), nurse (N ER1 S)
		AXR				ɚ	ur father (F AA1 DH ER); coward (K AW1 ER D)
		The following R-colored vowels are contemplated above
		EH R			ɛr	air (EH1 R); where (W EH1 R); hair (HH EH1 R)
		UH R			ʊr	cure (K Y UH1 R); bureau (B Y UH1 R OW0), detour (D IH0 T UH1 R)
		AO R			ɔr	more (M AO1 R); bored (B AO1 R D); chord (K AO1 R D)
		AA R			ɑr	large (L AA1 R JH); hard (HH AA1 R D)
		IH R or IY R	ɪr	ear (IY1 R); near (N IH1 R)
		AW R			aʊr	This seems to be a rarely used r-controlled vowel. In some dialects flower (F L AW1 R; in other dialects F L AW1 ER0)
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
		 
		 $svowels = array('ŏ','ē','o͞o','ĕ','ĭ','o͝o','ŭ','ă','ā','ī','ō','ow','oy','ur',
								 'ŏ1','ē1','o͞o1','ĕ1','ĭ1','o͝o1','ŭ1','ă1','ā1','ī1','ō1','ow1','oy1','ur1',
								 'ŏ2','ē2','o͞o2','ĕ2','ĭ2','o͝o2','ŭ2','ă2','ā2','ī2','ō2','ow2','oy2','ur2');

		for ($k=0; $k < 42; $k++) {
				if( strpos($SSWord,$svowels[$k]) !== false ){
					$SSWord = str_replace($svowels[$k], $svowels[$k].' ', $SSWord);
				}
		}

		 $tipSSWord = preg_split('/[\s]+/',$SSWord);
		 $tipcnt = count($tipSSWord);


		 $vowels = array('ŏ','ē','o͞o','ĕ','ĭ','o͝o','ŭ','ă',
	 									 'ā','ī','ō','ow','oy','ur');

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


		 $onset = array('pyo͞o','byo͞o','myo͞o','fyo͞o','kyo͞o','hyo͞o',
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
				$tip[$i] = 'ˈ'.$tip[$i];
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

// ファイルを変数に格納,インスタンス化
$a = new App();
$filename = 'cmudict-0.7b.txt';
$result = 'EngSS.txt';

// fopenでファイルを開く（'r'は読み込みモードで開く）
$fp = fopen($filename, 'r');
$handle = fopen($result, 'w');

// whileで行末までループ処理
while (!feof($fp)) {

 // fgetsでファイルから一行だけ読み込み、変数に格納
  $txt = fgets($fp);

 //一行をスペース２つ以上で分割
  $chtxt = preg_split('/[\s]{2,}/',$txt);

 // 変換する
  $b = $a->getSS($chtxt[1]);

 // EnとIPAをくっつける。utf8として無効な文字を削除? 改善の必要あり もし$cと$dが違ったら$cを出力で検査できないか
	$c=$chtxt[0]."\t".$b."\n";
	// $d = mb_convert_encoding($c, 'utf-8', 'utf-8');

 //書き込む
 fwrite($handle, $c);

}

// fcloseでファイルを閉じる
fclose($fp);
fclose($handle);

//もとのやつ $a = new App();
//もとのやつ $b = $a->getIPA('D AE1 M AH0 JH');

//never give up!

?>

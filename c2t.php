<?php


/**
 * Funkcija koja konvertuje broj u tekstualni zapis
 *
 * @example example.php Counting in action.
 * @param string $s Broj koji se konvertuje u tekstualni oblik
 * @param string $decimalseparator Separator decimala
 * @param string $thousandsseparator Separator za hiljade, ako ne postoji staviti prazan string
 * @param integer $spacelevel Broj u opsegu od 0-6 koji određuje gde se postavljaju space karakteri. Svaki sledeći nivo obuhvata i ceo prethodni.
 *
 * 0 - Nigde se ne postavljaju npr: minusjedanmilionpetstošezdesetšesthiljadatristatridesettridinarai00/100
 *
 * 1 - Postavljaju se u delu "i xx/100 npr: minusjedanmilionpetstošezdesetšesthiljadatristatridesettridinara i 00/100
 *
 * 2 - Postavljaju se ispred reči dinara npr: minusjedanmilionpetstošezdesetšesthiljadatristatridesettri dinara i 00/100
 *
 * 3 - Postavljaju se ispred predznaka minus npr: minus jedanmilionpetstošezdesetšesthiljadatristatridesettri dinara i 00/100
 *
 * 4 - Postavlja se na mesto gde bi bio postavljem separator hiljada npr: minus jedanmilion petstošezdesetšesthiljada tristatridesettri dinara i 00/100
 *
 * 5 - Postavlja se ispred reči hiljada, miliona, milijardi npr: minus jedan milion petstošezdesetšest hiljada tristatridesettri dinara i 00/100
 *
 * 6 - Postavlja se između svake reči npr: minus jedan milion petsto šezdeset šest hiljada trista trideset tri dinara i 00/100
 * @return string
 */
function Currency2Txt($s, $decimalseparator='.', $thousandsseparator='', $spacelevel=1) {
    $jedinice = [
        [
            '',         'jedna',     'dve',        'tri',       'četiri',
            'pet',      'šest',      'sedam',      'osam',      'devet',
            'deset',    'jedanaest', 'dvanaest',   'trinaest',  'četrnaest',
            'petnaest', 'šesnaest',  'sedamnaest', 'osamnaest', 'devetnaest'
        ],
        [
            '',         'jedan',     'dva',        'tri',       'četiri',
            'pet',      'šest',      'sedam',      'osam',      'devet',
            'deset',    'jedanaest', 'dvanaest',   'trinaest',  'četrnaest',
            'petnaest', 'šesnaest',  'sedamnaest', 'osamnaest', 'devetnaest'
        ]
    ];

    $desetice = [ '', '', 'dvadeset', 'trideset', 'četrdeset', 'pedeset', 'šezdeset', 'sedamdeset', 'osamdeset', 'devedeset' ];
    
    $stotine  = [ '', 'sto', 'dvesta', 'trista', 'četirsto', 'petsto', 'šesto', 'sedamsto', 'osamsto', 'devetsto' ];

    $sl = [
        [ '',  '',  '',  '',  '',  '' ],
        [ '',  ' ', '',  '',  '',  '' ],
        [ ' ', ' ', '',  '',  '',  '' ],
        [ ' ', ' ', ' ', '',  '',  '' ],
        [ ' ', ' ', ' ', ' ', '',  '' ],
        [ ' ', ' ', ' ', ' ', ' ', '' ],
        [ ' ', ' ', ' ', ' ', ' ', ' '],
    ];
			
    $prilozi  = [
        1 => [ -1 => $sl [$spacelevel][0].'dinar',  0 => 'a',   1 => '',    2 => 'a',   3 => 'a',   4 => 'a',   5 => 'a' ],
        2 => [ -1 => 'hiljad',                      0 => 'a',   1 => 'a',   2 => 'e',   3 => 'e',   4 => 'e',   5 => 'a' ],
        3 => [ -1 => 'milion',                      0 => 'a',   1 => '',    2 => 'a',   3 => 'a',   4 => 'a',   5 => 'a' ],
        4 => [ -1 => 'milijard',                    0 => 'i',   1 => 'a',   2 => 'e',   3 => 'e',   4 => 'e',   5 => 'i' ],
        5 => [ -1 => 'bilion',                      0 => 'a',   1 => '',    2 => 'a',   3 => 'a',   4 => 'a',   5 => 'a' ],
        6 => [ -1 => 'bilijard',                    0 => 'i',   1 => 'a',   2 => 'e',   3 => 'e',   4 => 'e',   5 => 'i' ],
        7 => [ -1 => 'trilion',                     0 => 'a',   1 => '',    2 => 'a',   3 => 'a',   4 => 'a',   5 => 'a' ],
        8 => [ -1 => 'trilijard',                   0 => 'i',   1 => 'a',   2 => 'e',   3 => 'e',   4 => 'e',   5 => 'i' ],
        9 => [ -1 => 'kvadrilion',                  0 => 'a',   1 => '',    2 => 'a',   3 => 'a',   4 => 'a',   5 => 'a' ],
    ];			


		
    $s = str_replace($thousandsseparator, '', $s);

    if (substr ($s, 0, 1) == '-') {
        $predznak = 'minus';
        $s = substr ($s, 1);
    } else {
        $predznak = '';
    }
		
    if (strpos ($s, $decimalseparator)) {
        $delovi = explode ($decimalseparator, $s);
        $s = $delovi[0];
        $stoti = $delovi[1];
        unset ($delovi);
        if (strlen ($stoti) < 2) { $stoti = $stoti.'0'; }
        if (strlen ($stoti) > 2) { $stoti = substr ($stoti, 0, 2); }
    } else {
        $stoti='';
    }
		
    while (strlen ($stoti) < 2) { $stoti = '0'.$stoti; };
		
    if ($s == 0) {
        $result = 'nula'.$sl [$spacelevel][0].'dinara';
        if ($stoti == '00') { $predznak = ''; }
    } else {
        while (strlen ($s) % 3 != 0) { $s = '0'.$s; }
        $result = '';
			
        for ($x=1; $x <= 9; $x++) {
            $trojka = substr ($s, -3);
            $s = substr ($s, 0, -3);
            if ($trojka == '') { $trojka = '000'; }
            if ($trojka != '000') {
                $idx = $x % 2;
                if ((substr ($trojka, 1, 1) == '0') or (substr ($trojka, 1, 1) == '1')) {
                    $temp = $sl[$spacelevel][5].$jedinice [$idx][(int) (substr ($trojka, 1, 1).substr ($trojka, 2, 1))];
                } else {
                    $temp = $sl[$spacelevel][5].$desetice [(int) (substr ($trojka, 1, 1))].$sl[$spacelevel][5].$jedinice[$idx][(int) (substr($trojka, 2, 1))];
                }
                $temp = $stotine[substr($trojka, 0, 1)].$temp;

                if (((int) (substr ($trojka, 1, 1).substr ($trojka, 2, 1)) <= 5) Or ((int) (substr ($trojka, 1, 1).substr ($trojka, 2, 1)) > 20)) {
                    if ((int) (substr($trojka, 2, 1)) <= 5) {
                        $temp = $temp.$sl[$spacelevel][4].$prilozi [$x][-1].$prilozi [$x][(int) (substr($trojka, 2, 1))];
                    } else {
                        $temp = $temp.$sl[$spacelevel][4].$prilozi [$x][-1].$prilozi [$x][5];
                    }
                } else {
                    $temp = $temp.$sl[$spacelevel][4].$prilozi [$x][-1].$prilozi [$x][5];
                }
                $result = $sl[$spacelevel][3].$temp.$result;
            } else {
                if ($x == 1) {
                    $result = $result.$sl [$spacelevel][0].'dinara';
                }
            }
        }
    }
    $result=($predznak.$sl [$spacelevel][2].$result.$sl [$spacelevel][1].'i'.$sl [$spacelevel][1].$stoti.'/100');
    while (strpos($result, '  ')>-1) {
        $result=str_replace('  ', ' ', $result);
    }
    return trim($result);
}


?>
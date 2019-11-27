# CurrencyToSerbianText
PHP funkcija koja konvertuje broj u tekstualni zapis

U Srpskom jeziku, za razliku od Engleskog, zbog gramatike, prilično je komplikovano uraditi konverziju broja u tekstualni oblik koji je pogodan za prikaz na računima, predračunima itd.

Šta zapravo ova funkcija radi? Za zadati broj, vraća isti taj broj prikazan u tekstualnom obliku. 

Npr: Za zadati broj: **123456.78**

Funkcija vraća: **stodvadesettrihiljadečetirstopedesetsest dinara i 78/100**

Ova funkcija podržava brojeve do **999999999999999999999999999.99**, odnosno **devetsto devedeset devet kvadriliona devetsto devedeset devet trilijardi devetsto devedeset devet triliona devetsto devedeset devet bilijardi devetsto devedeset devet biliona devetsto devedeset devet milijardi devetsto devedeset devet miliona devetsto devedeset devet hiljada devetsto devedeset devet dinara i 99/100**

Takođe, podržava pozitivne i negativne brojeve, podešavanje decimalnih separatora i separatora za hiljade, a još jedna zgodna stvar je i SpaceLevel parametar koji određuje 
gde će se ubacivati space karakteri u tekst (više o ovome malo kasnije).


Primer korišćenja funkcije:
```
echo Currency2Txt('-123,456.78', '.', ',', 3);
```


Objašnjenje parametara funkcije: 

* $s - Broj koji se konvertuje (može da ima - predznak)
* $decimalseparator - Separator decimale
* $thousandseparator - Separator za hiljade, ako ne postoji staviti prazan string
* $spacelevel - Broj u opsegu od 0-6 koji određuje gde se postavljaju space karakteri. Svaki sledeći nivo obuhvata i ceo prethodni.
    * 0 - Nigde se ne postavljaju
	npr: minusjedanmilionpetstošezdesetšesthiljadatristatridesettridinarai00/100
    * 1 - Postavljaju se u delu "i xx/100
	npr: minusjedanmilionpetstošezdesetšesthiljadatristatridesettridinara i 00/100
    * 2 - Postavljaju se ispred reči dinara
	npr: minusjedanmilionpetstošezdesetšesthiljadatristatridesettri dinara i 00/100
    * 3 - Postavljaju se ispred predznaka minus
	npr: minus jedanmilionpetstošezdesetšesthiljadatristatridesettri dinara i 00/100
    * 4 - Postavlja se na mesto gde bi bio postavljem separator hiljada
	npr: minus jedanmilion petstošezdesetšesthiljada tristatridesettri dinara i 00/100
    * 5 - Postavlja se ispred reči hiljada, miliona, milijardi 
	npr: minus jedan milion petstošezdesetšest hiljada tristatridesettri dinara i 00/100
    * 6 - Postavlja se između svake reči
	npr: minus jedan milion petsto šezdeset šest hiljada trista trideset tri dinara i 00/100
	
Što se tiče imenovanja brojeva, urađeno je prema [SI sistemu jedinica za pefikse (duga skala)](http://sr.wikipedia.org/wiki/%D0%A1%D0%98_%D0%BF%D1%80%D0%B5%D1%84%D0%B8%D0%BA%D1%81).
Ako pri korišćenju ove funkcije dobijate žvrljotine umesto YU slova, proverite da li ste u HEAD stavili
```<meta charset="utf-8">```
# TTMS0500/0900 Web- ja palvelinohjelmoinnin harjoitustyö

### Matti Ruusupiha & Mikko Seppänen

25.11.2017

### Tehtävän kuvaus

Päätimme yhdistää molempien kurssien (ttms0500 ja ttms0900) harjoitustyöt yhdeksi kokonaisuudeksi. Koska olemme molemmat
suuntautuneet kyberturvallisuuteen, päätimme, että harjoitustyömme tulee olemaan jotenkin yhteydessä kyberturvallisuusasioihin.
Saimme ajatukseksemme rakentaa niin kutsutun "honeypot" -serverin. Tällaisen serverin tarkoituksena on ylläpitää virtuaalista
käyttöjärjestelmää, johon kirjautuminen ei vaadi autentikoitumista. Tällaiset serverit ovat omiaan houkuttelemaan hakkereita ja
botteja, jotka kirjautuvat "honeypot" -serverille ja toimivat siellä paha-aikeisesti. Tämä toiminta kirjataan lokeihin, ja 
tietoturva-asiantuntijat voivat tutkia näitä lokeja selvittääkseen bottien ja hakkereiden trendejä. Päätimme rakentaa nettisivun, jonka
avulla voisimme visualisoida kyseistä dataa ja kerätä mielenkiintoista statistiikkaa.

### Ympäristön rakentaminen

Lyhyen etsinnän jälkeen päätimme käyttää "honeypot" ympäristönämme [Cowrie](https://github.com/micheloosterhof/cowrie) -hunajapurkkia,
joka perustuu jo meille ennestään tuttuun Kippoon. Cowrie mahdollistaa lokien tallentamisen sekä MySQL -tietokantaan että JSON -
tiedostoon. Alustaksemme valitsimme Ubuntu VPS:n. [Asensimme](lamp.md) serverille Apachen ja php moduulit myöhempää käyttöä varten.

Cowrien [asentaminen](cowrie.md) sujui melko vaivatta. Yritimme ensin [lukea](write-to-database.php) Cowrien json -tiedostoa ja 
kirjoittaa
tämän datan MySQL -tietokantaan. Tämä metodi alkoi kuitenkin tuntua meistä hieman vaivalloiselta, siellä cowriessa oli oma MySQL -
tietokantaan tallennusfunktionaalisuus. Lisäksi kirjoittamamme php scripti joskus kirjoitti JSON tiedoston alkuun NULL -tavuja, joka
vuorostaan aiheutti sen, että seuraavalla lukukierroksella luku osittain epäonnistui. Näistä syistä päätimme konfiguroida 
[Cowrien oman](cowrie-mysql.md) tietokantaankirjoittamisfunktionaalisuuden. Tämä toimi moitteetta.  

MIKKO tähän vois kertoa npm asennuksesta ja reaktista.

### Käytännön toteutus

Tämän jälkeen olikin aika ryhtyä visualisoimaan dataa. Päätimme aloittaa viivagraafista, joka näyttäisi kirjautumisyritysten määrän
päivämäärää kohti. Ensiksi kirjoitimme tietokannan [alustusskriptin](init-db.php), joka sijoitettiin kansioon, jota Apache ei pääse 
lukemaan. Tätä alustusskriptiä tulevat käyttämään kaikki sitä seuraavat php -skriptit. Tämän jälkeen kirjoitimme
[get-login-attempts](ajax/get-login-attempts.php) -skriptin, joka hakee tietokannan "sessions" -kansiosta kirjautumisten 
aloitusajankohdat. Ajankohdat yleistetään päivän tarkkuudelle käyttämällä explode -funktiota välilyönnin kohdalla. Tämä data luetaan 
array -tietorakenteeseen käyttäen kätevää php:n array_count_values funktiota, joka antaa meille suoraan
tietorakenteen, jonka jokaisen tietueen avaimena on kirjautumispäivämäärä ja arvona kyseisenä päivänä tapahtuneiden kirjautumisten 
määrä. Tämä array puolestaan kirjoitetaan json -muotoon ja palautetaan. MIKKO tähän js.   

Seuraavana oli vuorossa hunajapurkkiin pyrkivien maantieteellisen sijainnin selvittäminen ja visualisoiminen karttaan. Tätä tehtävää
varten päätimme käyttää hyödyksi [geoPlugin](http://www.geoplugin.com) API:a. Valitsimme geoPluginin siitä syystä, että heidän 
palveluihinsa sisältyy php -palvelu, joka kutsuttaessa palauttaa php:lle sopivan array -tietorakenteen. Tieto käsittelevä 
[geo.php](geo.php) lukee tietokannasta 65 viimeisintä kirjautumisyritystä ja palauttaa niihin liittyvät yksilölliset ip -osoitteet 
(ei duplikaatteja). Tämän jälkeen kyseiset osoitteet loopataan ja jokaista kohden tehdään geoPlugin kysely. Ensin ajattelimme
kutsua suoraan tätä skriptiä datan visualisointisivulta. Emme kuitenkaan ottaneet huomioon sitä, että jokaisella sivun latauskerralla
loimme runsaasti liikennettä geoPlugin API:in. He muistuttivat meitä tästä faktasta antamalle meille tunnin bännit. Tämän jälkeen
päätimme ajaa geo.php:n cronjobilla joka viides minuutti, ja kirjoittaa tulokset erilliseen json -tiedostoon, jota datan 
visualisointisivu lukee. Näin luomamme liikenne ei rasita turhaan geoPlugin API:a. Geo.php sijoitettiin kansioon, johon ei voi 
selata selaimella, jotta voimme olla varmoja siitä, että ylimääräistä liikennettä geoPlugin API:in ei luoda. MIKKO js.   

Mielestämme olisi myös mukavaa nähdä dataa kaikkein eniten käytetyistä salasanoista ja käyttäjänimistä. Niimpä kirjoitimme kaksi
skriptiä, [get-passwords.php](ajax/get-passwords.php) ja [get-usernames.php](ajax/get-usernames.php). Nämä skriptit eivät käytännössä 
eroa muuten toisistaan kuin sen datan perustella, mitä ne hakevat tietokannasta. Data luetaan array -tietorakenteesta sekä muutetaan
json -muotoiseksi ja palautetaan. MIKKO js.   

Loppuhuipennukseksi päätimme vielä luoda taulukon, jossa näkyisi 10 viimeisintä kirjautumisyritystä ip-osoitteineen, 
autentikointidatoineen höystettynä aikaleimalla. Tätä varten kirjoitimme [get-datarow.php](ajax/get-datarow.php) -skriptin, jonka
SQL tiedustelu palautti meille juuri tarvitsemamme datan. Tämän tiedustelun kirjottaiminen olikin tehtävän palvelinosuuden vaikein
kohta, sillä kun data saatiin array -rakenteeseen, se oli helppo tunttuun tapaan muuttaa json -muotoiseksi ja palauttaa. MIKKO js.   

Seuraavaan rakennekaavioon olemme kuvanneet serverin käyttämien palveluiden ja tiedostojen suhteita.

###### Rakennekaavio

![arch](pictures/arch.png)

Parempaa käyttäjäkokemusta silmällä pitäen rekisteröimme sivumme käyttäen [FreeDNS](https://freedns.afraid.org/) nimipalvelua, sekä
kirjoitimme [aloittussivun](landing_page/index.html), jossa luetellaan projektissa käyttämämme oleelliset ulkoiset palvelut ja joka 
sisältää linkin datan visualisoimissivulle. Rekisteröimme myös uuden domainimme geoPlugin -palveluun. Kirjoitimme aloitussivua varten
pienen javascriptin, joka css filter -ominaisuutta käyttäen hitaasti vaihtaa aloitussivun taustakuvan kontrastia, joka saa aikaan
eloisan hehkun.

### Ajankäyttö ja roolit

Tehtävämme jakautuivat melko selkeästi niin, että Matti keskittyä pääasiassa backend -ohjelmointiin ja Mikko frontend -ohjelmointiin. 
Teimme myös kuitenkin molemmat hiukan molempia, esimerkiksi Mikko suunnitteli suurimmaksi osaksi geo.php -skriptin geoIP osuuden, kun 
taas Matti esimerkiksi osallistui Lines.js tiedoston taulukon renderöimisfunktion tekemiseen. Työskentelimme monesti yhtä aikaa, ja
huomasimme tehokkaaksi seuraavan työjärjestyksen: Mikko selvitti ensin, millaista json dataa tarvittiin ja loi esimerkiksi json 
-tiedoston. Tämän jälkeen Mikko jatkoi tarvittavan .js sivun tekemistä, kun taas Matti ohjelmoi tarvittavan PHP -skriptin. Lopuksi
molemmat lyötiin yhteen ja korjattiin mahdolliset puutteet.

###### Ajankäyttö:

Nimi | 17.11 | 18.11 | 19.11 | 20.11 | 21.11 | 22.11 | 24.11 | 25.11
------------ | ------------- | ------------- | ------------- | ------------- | ------------- | ------------- | ------------- | -------------
Matti | 6h | 4h | 6h | 8h | 5h | 2h | 8h | 5h
Mikko | xh | xh | xh | xh | xh | xh | xh | xh

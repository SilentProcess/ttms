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

Lyhyen etsinnän jälkeen päätimme käyttää "honeypot" ympäristönämme Cowrie -hunajapurkkia, joka perustuu jo meille ennestään tuttuun
Kippoon. Cowrie mahdollistaa lokien tallentamisen sekä MySQL -tietokantaan että JSON -tiedostoon. Alustaksemme valitsimme Ubuntu VPS:n.
[Asensimme](lamp.md) serverille Apachen ja php moduulit myöhempää käyttöä varten.

Cowrien [asentaminen](cowrie.md) sujui melko vaivatta. Yritimme ensin [lukea](write-to-database.php) Cowrien json -tiedostoa ja kirjoittaa
tämän datan MySQL -tietokantaan. Tämä metodi alkoi kuitenkin tuntua meistä hieman vaivalloiselta, siellä cowriessa oli oma MySQL -
tietokantaan tallennusfunktionaalisuus. Lisäksi kirjoittamamme php scripti joskus kirjoitti JSON tiedoston alkuun NULL -tavuja, joka
vuorostaan aiheutti sen, että seuraavalla lukukierroksella luku osittain epäonnistui. Näistä syistä päätimme konfiguroida 
[Cowrien oman](cowrie-mysql.md) tietokantaankirjoittamisfunktionaalisuuden. Tämä toimi moitteetta.  

MIKKO tähän vois kertoa npm asennuksesta.

### Käytännön toteutus

Tämän jälkeen olikin aika ryhtyä visualisoimaan dataa. Päätimme aloittaa viivagraafista, joka näyttäisi kirjautumisyritysten määrän
päivämäärää kohti. Ensiksi kirjoitimme tietokannan [alustusskriptin](init-db.php), joka sijoitettiin kansioon, jota Apache ei pääse 
lukemaan. Tätä alustusskriptiä tulevat käyttämään kaikki sitä seuraavat php -skriptit. Tämän jälkeen kirjoitimme
[get-login-attempts](ajax/get-login-attempts.php) -skriptin, joka hakee tietokannan "sessions" -kansiosta kirjautumisten 
aloitusajankohdat. Ajankohdat yleistetään  Nämä luetaan array -tietorakenteeseen käyttäen kätevää php:n array_count_values funktiota, joka antaa meille suoraan
tietorakenteen, jonka jokaisen tietueen avaimena on kirjautumispäivämäärä ja arvona kyseisenä päivänä tapahtuneiden kirjautumisten määrä.

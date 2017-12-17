### SQL komentoja
```
SELECT DISTINCT input.session, count(input.input) AS count, auth.timestamp 
FROM input 
INNER JOIN auth ON input.session=auth.session 
GROUP BY input.session, auth.timestamp 
HAVING count>3 
ORDER BY MAX(auth.timestamp);
```
Tuo listaa kaikki eri sessio hashit sekä niiden tekemien inputtien lukumäärän sekä hakee auth logista session timestampin  
listaa vain yli 3 komentoa käyttäneet  

```
SELECT input FROM input where session = '344364c22080';
```
Listaa valitun hashing perusteella input taulusta input rivit

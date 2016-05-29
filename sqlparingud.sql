/*Tabelid:

mkeerus_pr_kasutajad

Veerud:
  * id
  * kasutajanimi
  * parool
  * eesnimi
  * perekonnanimi
  * muut_aeg timestamp


Neid hetkel pole:
  * sugu (et oleks �ks radiobutton)
  * reg_aeg datetime

  */

  CREATE TABLE mkeerus_pr_kasutajad(
      id int AUTO_INCREMENT PRIMARY KEY,
      kasutajanimi varchar(100) NOT NULL UNIQUE,
      parool varchar(100) NOT NULL,
      eesnimi varchar(100) NOT NULL,
      perekonnanimi varchar(100) NOT NULL,
      sugu char(1),
      reg_aeg datetime NOT NULL,
      muut_aeg timestamp NOT NULL
  );


mkeerus_pr_ostud

/**
Veerud:
* id
* ostja
* pood
* kuupäev
* summa
*/


  CREATE TABLE mkeerus_pr_ostud(
      id int AUTO_INCREMENT PRIMARY KEY,
      ostja varchar(100) NOT NULL,
      pood varchar(100) NOT NULL,
      kuupaev date NOT NULL,
      summa decimal (10,2) NOT NULL,
      reg_aeg timestamp NOT NULL
  );

mkeerus_pr_osturead
/**
Veerud:
* id
* ostu_id
* kaup
* kategooria
* kogus
* hind
* rea summa

*/


  CREATE TABLE mkeerus_pr_purchase_rows(
      id int AUTO_INCREMENT PRIMARY KEY,
      purchase_id int NOT NULL,
      item varchar(100) NOT NULL,
      category varchar(100) NOT NULL,
      quantity decimal (10,3) NOT NULL,
      price decimal (10,2) NOT NULL,
      amount decimal (10,2) NOT NULL,
      reg_aeg timestamp NOT NULL
  );

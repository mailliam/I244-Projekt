/*Tabelid:

mkeerus_pr_kasutajad

Veerud:
  * id
  * kasutajanimi
  * parool
  * eesnimi
  * perekonnanimi
  * sugu (et oleks �ks radiobutton)
  * reg_aeg datetime
  * muut_aeg timestamp


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


mkeerus_pr_osturead

SELECT Taux, TOTAL FROM (SELECT Taux, IBB, BCB, KCB, IBB+BCB+KCB AS TOTAL 
                              FROM (SELECT Taux,
	                                    SUM(IF (Banque = 'BANCOBU', Montant, 0)) AS BANCOBU,
								        SUM(IF (Banque = 'BCB', Montant, 0)) AS BCB,
                                        SUM(IF (Banque = 'IBB', Montant, 0)) AS IBB
	                                  FROM (SELECT offers.rate AS Taux, offers.amount AS Montant, bank.name AS Banque
                                                   FROM offers INNER JOIN banks 
					                                    ON offers.id_bank = banks.id
									                        ORDER BY offers.rate DESC) AS recap
										                        GROUP BY Taux 
										                          ORDER BY Taux DESC) AS Ordonne)AS total;
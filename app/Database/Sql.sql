USE superhero;

SELECT * FROM superhero;


SELECT * FROM superhero WHERE alignment_id = 1;
SELECT * FROM superhero WHERE alignment_id = 2;
SELECT * FROM superhero WHERE alignment_id = 3;
SELECT * FROM superhero WHERE alignment_id = 4;

CREATE VIEW view_superhero_alignment AS
	SELECT
		AL.alignment,
		COUNT(SH.alignment_id) AS 'total'
		FROM superhero SH
		LEFT JOIN alignment AL ON AL.id = SH.alignment_id
		GROUP BY SH.alignment_id;
	

	SELECT 
		SH.id,
		SH.superhero_name,
		SH.full_name,
		GE.gender
		FROM superhero SH
		LEFT JOIN gender GE ON SH.gender_id = GE.id
		WHERE GE.id =2
		LIMIT 100;
		
	SELECT 
    PB.publisher_name AS Marca,
    COUNT(SH.id) AS Total_Heroes
		FROM publisher PB
		LEFT JOIN superhero SH ON SH.publisher_id = PB.id
		GROUP BY PB.publisher_name;
		
	SELECT 
    PB.publisher_name AS Marca,
    AVG(SH.weight_kg) AS Promedio_Peso
		FROM superhero SH
		LEFT JOIN publisher PB ON SH.publisher_id = PB.id
		GROUP BY PB.publisher_name
		ORDER BY Promedio_Peso ASC;

SELECT * FROM view_superhero_alignment	

SELECT * FROM race;
SELECT * FROM gender;
SELECT * FROM alignment;
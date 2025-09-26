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

SELECT * FROM view_superhero_alignment	

SELECT * FROM race;
SELECT * FROM gender;
SELECT * FROM alignment;
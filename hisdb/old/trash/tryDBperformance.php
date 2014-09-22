
<?php
$sql="
	SELECT patmast.Name, patmast.MRN, patmast.Sex, languagecode.Description Language, citizen.Description Citizen, racecode.Description Race, religion.Description
	FROM patmast, languagecode, citizen, racecode, religion
	WHERE patmast.LanguageCode = languagecode.LanguageCode
	AND patmast.CitizenCode = citizen.CitizenCode
	AND patmast.RaceCode = racecode.RaceCode
	AND patmast.Religion = religion.ReligionCode
	ORDER BY patmast.Name, patmast.Sex

";


?>

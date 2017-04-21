CREATE OR REPLACE FUNCTION updBets() RETURNS TRIGGER
AS $$
    BEGIN
    RAISE NOTICE ' VALOR OLD: % ', OLD.winneropt;	

	update clientbets set outcome = bet*ratio where clientbets.betid = OLD.betid and clientbets.optionid = NEW.winneropt;
	update clientbets set outcome = 0 where clientbets.betid = OLD.betid and clientbets.optionid != NEW.winneropt;

	return NEW;
    END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER t_updBets
	AFTER UPDATE OR INSERT ON bets
FOR EACH ROW EXECUTE PROCEDURE updBets();
	
		 
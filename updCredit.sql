CREATE OR REPLACE FUNCTION a() RETURNS TRIGGER
AS $$
    DECLARE
    aux1 record;
    BEGIN
        FOR aux1 IN SELECT outcome FROM clientbets WHERE NEW.orderid=clientbets.orderid GROUP BY orderid
            IF aux1.outcome IS NULL
                RETURN NEW;
            END IF;
        END LOOP;
        update customers SET credit=credit + NEW.totaloutcome WHERE NEW.customerid=customers.customerid;
        RETURN new;
        END;
        $$ LANGUAGE plpgsql;
--Restamos la apuesta al credito del cliente
CREATE OR REPLACE FUNCTION b() RETURNS TRIGGER
AS $$
	DECLARE
	BEGIN
		IF OLD.date IS NULL and NEW.date IS NOT NULL THEN
			UPDATE customers SET credit=credit-NEW.totalamount WHERE NEW.customerid=customers.customerid;
		END IF;
		RETURN new;
	END;
	$$ LANGUAGE plpgsql;

CREATE TRIGGER updCredit AFTER UPDATE OF date ON clientorders
FOR EACH ROW EXECUTE PROCEDURE b();

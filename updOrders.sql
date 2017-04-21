
CREATE OR REPLACE FUNCTION updOrders() RETURNS TRIGGER
AS $$
    DECLARE
    BEGIN
	
	--Planteamos cada caso por separado(Aunque en nuestro carro una vez insertada una apuesta no se borrara).
	IF (TG_OP = 'UPDATE') THEN
		IF NEW.outcome <> OLD.outcome THEN
			UPDATE clientorders SET totaloutcome=totaloutcome+NEW.outcome WHERE orderid=NEW.orderid;
		END IF; 
	--Si se borra una apuesta del cliente(en nuestra implementacion seria imposible), la ganancia total disminuye
	ELSIF (TG_OP = 'DELETE') THEN
		UPDATE clientorders SET totalamount=totalamount-OLD.bet WHERE orderid=OLD.orderid;
		IF OLD.outcome IS NOT NULL THEN
			UPDATE clientorders SET totaloutcome=totaloutcome-OLD.outcome WHERE orderid = OLD.orderid;			
		END IF;
	--Si se inserta una apuesta del cliente, la ganancia total aumenta
	ELSIF(TG_OP= 'INSERT') THEN
		UPDATE clientorders SET totalamount=totalamount+NEW.bet WHERE orderid=NEW.orderid;
		IF NEW.outcome IS NOT NULL THEN
			UPDATE clientorders SET totaloutcome = totaloutcome + NEW.outcome WHERE orderid = NEW.orderid;
		END IF;
	END IF;
	--ENDIF;
	RETURN NEW;
    END;


$$ LANGUAGE plpgsql;

CREATE TRIGGER t_updOrders
	AFTER UPDATE OR DELETE OR INSERT ON clientbets
FOR EACH ROW EXECUTE PROCEDURE updOrders();



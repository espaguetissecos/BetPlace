CREATE OR REPLACE FUNCTION setTotalOutCome() RETURNS int4 AS $$
DECLARE
    as_declare int4;
BEGIN
	create view total_sum as select clientbets.orderid, sum(outcome) from clientbets, bets where clientbets.betid = bets.betid and winneropt = optionid group by clientbets.orderid;
	update clientorders set totaloutcome = total_sum.sum from total_sum where clientorders.orderid = total_sum.orderid;
	update clientorders set totaloutcome = 0 where clientorders.orderid not in (select orderid from total_sum);
	drop view total_sum;
	as_declare := 1;
	return as_declare;
END
$$ LANGUAGE plpgsql;


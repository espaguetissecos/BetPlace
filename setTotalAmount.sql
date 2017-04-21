create view sumaBet as select orderid, sum(bet) from clientbets group by orderid; 
update clientorders set totalamount = sum from sumaBet where clientorders.orderid = sumaBet.orderid; 
drop view sumaBet;

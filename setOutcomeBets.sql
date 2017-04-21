drop view apuestas_ok;
create view apuestas_ok as select clientbets.betid, clientbets.optionid from clientbets, bets where clientbets.betid = bets.betid and winneropt = optionid;
update clientbets set outcome = bet*ratio where (clientbets.optionid, clientbets.betid)  in (select apuestas_ok.optionid, apuestas_ok.betid from apuestas_ok);
update clientbets set outcome = 0 where (clientbets.optionid, clientbets.betid)  not in (select apuestas_ok.optionid, apuestas_ok.betid from apuestas_ok);
drop view apuestas_ok;



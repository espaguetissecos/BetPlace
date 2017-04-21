ALTER TABLE clientorders ADD COLUMN totaloutcome numeric;

ALTER SEQUENCE clientorders_id_seq RESTART WITH 149031;

ALTER SEQUENCE customers_customerid_seq RESTART WITH 14093

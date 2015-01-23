CREATE TABLE test_table
(
  name text NOT NULL,
  CONSTRAINT test_table_pk PRIMARY KEY (name)
);

INSERT INTO test_table (name) VALUES('jill'), ('jane'), ('joe');

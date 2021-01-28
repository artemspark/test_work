create table advertisements
(
    id      int auto_increment
        primary key,
    text    text          not null,
    price   float         not null,
    amount  int default 0 null,
    counter int default 0 not null,
    banner  text          null
);

INSERT INTO test_work.advertisements (id, text, price, amount, counter, banner) VALUES (2, 'test message', 1000, 3, 4, null);
INSERT INTO test_work.advertisements (id, text, price, amount, counter, banner) VALUES (3, 'test message', 1000, 6, 6, null);
INSERT INTO test_work.advertisements (id, text, price, amount, counter, banner) VALUES (4, 'test message', 1000, 200, 92, null);
INSERT INTO test_work.advertisements (id, text, price, amount, counter, banner) VALUES (5, 'test message', 1000, 200, 0, null);
INSERT INTO test_work.advertisements (id, text, price, amount, counter, banner) VALUES (6, 'test message', 1000, 200, 0, null);
INSERT INTO test_work.advertisements (id, text, price, amount, counter, banner) VALUES (7, 'test message', 1000, 200, 0, null);
INSERT INTO test_work.advertisements (id, text, price, amount, counter, banner) VALUES (8, 'small text', 300, 10, 10, null);
INSERT INTO test_work.advertisements (id, text, price, amount, counter, banner) VALUES (9, 'small text', 500, 0, 7, null);
INSERT INTO test_work.advertisements (id, text, price, amount, counter, banner) VALUES (10, 'small text', 5000, 0, 4, null);
INSERT INTO test_work.advertisements (id, text, price, amount, counter, banner) VALUES (11, 'small text', 300, 0, 0, null);
INSERT INTO test_work.advertisements (id, text, price, amount, counter, banner) VALUES (12, 'small text', 300, 0, 0, null);
INSERT INTO test_work.advertisements (id, text, price, amount, counter, banner) VALUES (13, 'small text', 10000, 0, 7, null);
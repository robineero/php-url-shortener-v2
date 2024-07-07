DROP TABLE IF EXISTS link;
DROP TABLE IF EXISTS log;

CREATE TABLE link
(
    id integer primary key,
    url text,
    comment text,
    slug text unique,
    is_active int,
    is_private int,
    created_at text
);

CREATE TABLE log (
     link_id integer,
     created_at text
 );

INSERT INTO link (slug, url) values ('abc', '');
INSERT INTO link (slug, url) values ('xyz', '');
INSERT INTO log (link_id) values (1);
INSERT INTO log (link_id) values (1);

SELECT link.created_at, typeof(link.created_at) from link;
DELETE FROM link WHERE id = 1;
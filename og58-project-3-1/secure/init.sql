BEGIN TRANSACTION;

CREATE TABLE gallery (
	id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	file_name TEXT NOT NULL UNIQUE,
	caption TEXT,
  date_taken TEXT,
	file_ext TEXT
);

-- images seed data
INSERT INTO gallery (file_name, caption, date_taken, file_ext) VALUES ('miami_beach.jpg', 'Miami Beach', '2012-06-12','jpg');
INSERT INTO gallery (file_name, caption, date_taken, file_ext) VALUES ('gulmarg.jpg', 'Gulmarg', '2002-09-23','jpg');
INSERT INTO gallery (file_name, caption, date_taken, file_ext) VALUES ('nassau.jpg', 'Nassau', '2018-12-01','jpg');
INSERT INTO gallery (file_name, caption, date_taken, file_ext) VALUES ('dubai.jpg', 'Dubai', '2014-01-16','jpg');
INSERT INTO gallery (file_name, caption, date_taken, file_ext) VALUES ('disneyland.jpg', 'Disneyand', '2009-05-15','jpg');
INSERT INTO gallery (file_name, caption, date_taken, file_ext) VALUES ('taj_mahal.jpg', 'Taj Mahal', '2011-12-19','png');
INSERT INTO gallery (file_name, caption, date_taken, file_ext) VALUES ('masai_mara.jpg', 'Masai Mara', '2008-09-09','png');
INSERT INTO gallery (file_name, caption, date_taken, file_ext) VALUES ('santorini.jpeg', 'Santorini', '2020-04-14','jpeg');
INSERT INTO gallery (file_name, caption, date_taken, file_ext) VALUES ('switzerland.jpeg', 'Switzerland', '2009-05-31','jpeg');
INSERT INTO gallery (file_name, caption, date_taken, file_ext) VALUES ('gir_forest.jpeg', 'Gir Forest', '2011-09-19','jpeg');



CREATE TABLE tags (
	id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	tag TEXT
);

-- tags seed data
INSERT INTO tags (id, tag) VALUES (1, 'All images');
INSERT INTO tags (id, tag) VALUES (2, 'Beaches');
INSERT INTO tags (id, tag) VALUES (3, 'USA');
INSERT INTO tags (id, tag) VALUES (4, 'Asia');
INSERT INTO tags (id, tag) VALUES (5, 'Wildlife');
INSERT INTO tags (id, tag) VALUES (6, 'Mountains');
INSERT INTO tags (id, tag) VALUES (7, 'India');
INSERT INTO tags (id, tag) VALUES (8, 'Europe');




CREATE TABLE image_tags (
	id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	gallery_id INTEGER NOT NULL,
	tag_id INTEGER NOT NULL
);

-- image_tags seed data
INSERT INTO image_tags (id, gallery_id, tag_id) VALUES (1, 1, 1);
INSERT INTO image_tags (id, gallery_id, tag_id) VALUES (2, 1, 2);
INSERT INTO image_tags (id, gallery_id, tag_id) VALUES (3, 1, 3);

INSERT INTO image_tags (id, gallery_id, tag_id) VALUES (4, 2, 1);
INSERT INTO image_tags (id, gallery_id, tag_id) VALUES (5, 2, 4);
INSERT INTO image_tags (id, gallery_id, tag_id) VALUES (6, 2, 6);
INSERT INTO image_tags (id, gallery_id, tag_id) VALUES (7, 2, 7);

INSERT INTO image_tags (id, gallery_id, tag_id) VALUES (8, 3, 1);
INSERT INTO image_tags (id, gallery_id, tag_id) VALUES (9, 3, 2);

INSERT INTO image_tags (id, gallery_id, tag_id) VALUES (10, 4, 1);
INSERT INTO image_tags (id, gallery_id, tag_id) VALUES (11, 4, 4);
INSERT INTO image_tags (id, gallery_id, tag_id) VALUES (12, 4, 2);

INSERT INTO image_tags (id, gallery_id, tag_id) VALUES (13, 5, 1);
INSERT INTO image_tags (id, gallery_id, tag_id) VALUES (14, 5, 3);

INSERT INTO image_tags (id, gallery_id, tag_id) VALUES (15, 6, 1);
INSERT INTO image_tags (id, gallery_id, tag_id) VALUES (16, 6, 4);
INSERT INTO image_tags (id, gallery_id, tag_id) VALUES (17, 6, 7);

INSERT INTO image_tags (id, gallery_id, tag_id) VALUES (18, 7, 1);
INSERT INTO image_tags (id, gallery_id, tag_id) VALUES (19, 7, 5);

INSERT INTO image_tags (id, gallery_id, tag_id) VALUES (20, 8, 1);
INSERT INTO image_tags (id, gallery_id, tag_id) VALUES (21, 8, 2);
INSERT INTO image_tags (id, gallery_id, tag_id) VALUES (22, 8, 8);

INSERT INTO image_tags (id, gallery_id, tag_id) VALUES (23, 9, 1);
INSERT INTO image_tags (id, gallery_id, tag_id) VALUES (24, 9, 6);
INSERT INTO image_tags (id, gallery_id, tag_id) VALUES (25, 9, 8);

INSERT INTO image_tags (id, gallery_id, tag_id) VALUES (26, 10, 1);
INSERT INTO image_tags (id, gallery_id, tag_id) VALUES (27, 10, 4);
INSERT INTO image_tags (id, gallery_id, tag_id) VALUES (28, 10, 5);
INSERT INTO image_tags (id, gallery_id, tag_id) VALUES (29, 10, 7);

COMMIT;

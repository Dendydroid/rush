CREATE TABLE rush.users
(
    id SERIAL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    data json DEFAULT NULL,
    created_at INT NOT NULL
);
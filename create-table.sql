create table [dbo].[user](
    id INT NOT NULL IDENTITY(1,1) PRIMARY KEY(id),
    name VARCHAR(30),
    username VARCHAR(30),
    job VARCHAR(30)
);
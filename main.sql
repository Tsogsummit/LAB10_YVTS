CREATE DATABASE IF NOT EXISTS HouseholdDatabase;
USE HouseholdDatabase;

CREATE TABLE Items (
    item_id INT PRIMARY KEY,
    item_name VARCHAR(255) NOT NULL
);

CREATE TABLE Users (
    user_id INT PRIMARY KEY,
    user_name VARCHAR(255) NOT NULL
);

CREATE TABLE ItemUsage (
    usage_id INT PRIMARY KEY,
    user_id INT,
    item_id INT,
    quantity INT,
    FOREIGN KEY (user_id) REFERENCES Users(user_id),
    FOREIGN KEY (item_id) REFERENCES Items(item_id)
);

-- Insert data into Items table
INSERT INTO Items (item_id, item_name) VALUES
    (1, 'Toaster'),
    (2, 'Coffee Maker'),
    (3, 'Blender'),
    (4, 'Microwave'),
    (5, 'Vacuum Cleaner');

-- Insert data into Users table
INSERT INTO Users (user_id, user_name) VALUES
    (101, 'Alice'),
    (102, 'Bob'),
    (103, 'Charlie'),
    (104, 'David'),
    (105, 'Eva');

-- Insert data into ItemUsage table
INSERT INTO ItemUsage (usage_id, user_id, item_id, quantity) VALUES
    (1001, 101, 1, 2),  -- Alice used 2 toasters
    (1002, 102, 2, 1),  -- Bob used 1 coffee maker
    (1003, 103, 3, 3),  -- Charlie used 3 blenders
    (1004, 101, 2, 1),  -- Alice used 1 coffee maker
    (1005, 103, 4, 1),  -- Charlie used 1 microwave
    (1006, 104, 2, 2),  -- David used 2 coffee makers
    (1007, 105, 5, 1),  -- Eva used 1 vacuum cleaner
    (1008, 101, 4, 1);  -- Alice used 1 microwave

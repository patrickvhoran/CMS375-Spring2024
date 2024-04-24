-- Worked on by Ryan Patrick and Edward concurrently

drop database if exists transport;
create database if not exists transport;
use transport;


-- Create Tables
CREATE TABLE Station (
    StationID INT PRIMARY KEY AUTO_INCREMENT,
    StationName VARCHAR(100) NOT NULL,
    Gates INT NOT NULL
);


CREATE TABLE Routes (
    RouteID INT PRIMARY KEY AUTO_INCREMENT,
    DepartureLocationID INT NOT NULL,
    ArrivalLocationID INT NOT NULL,
    DepartureTime DATETIME NOT NULL,
    TransportType VARCHAR(10) NOT NULL,
    OpenSeats INT NOT NULL,
    Price NUMERIC(5,2) NOT NULL,
    FOREIGN KEY (DepartureLocationID) REFERENCES Station(StationID),
    FOREIGN KEY (ArrivalLocationID) REFERENCES Station(StationID)
);

CREATE TABLE Passenger (
    PassengerID INT PRIMARY KEY AUTO_INCREMENT,
    Username VARCHAR(50) NOT NULL,
    Password VARCHAR(100) NOT NULL
);

CREATE TABLE Takes (
    TakesID INT PRIMARY KEY AUTO_INCREMENT,
    PassengerID INT NOT NULL,
    RouteID INT NOT NULL,
    FOREIGN KEY (PassengerID) REFERENCES Passenger(PassengerID),
    FOREIGN KEY (RouteID) REFERENCES Routes(RouteID)
);



CREATE TABLE Bikes (
	BikeID INT PRIMARY KEY AUTO_INCREMENT,
    CurrentLocation VARCHAR(25) NOT NULL,
    Available BOOLEAN NOT NULL
);

INSERT INTO Station (StationName, Gates) 
VALUES 
('Station A', 5),
('Station B', 3),
('Station C', 7),
('Station D', 4),
('Station E', 6),
('Station F', 2),
('Station G', 8),
('Station H', 3),
('Station I', 5),
('Station J', 4);


INSERT INTO Routes (DepartureLocationID, ArrivalLocationID, DepartureTime, TransportType, OpenSeats, Price) 
VALUES 
(1, 5, '2024-03-28 08:00:00', 'Train', 50, 25.00),
(2, 8, '2024-03-28 09:00:00', 'Bus', 30, 15.50),
(3, 4, '2024-03-28 10:00:00', 'Plane', 100, 100.00),
(5, 2, '2024-03-28 11:00:00', 'Train', 40, 20.00),
(6, 9, '2024-03-28 12:00:00', 'Bus', 20, 10.00),
(7, 3, '2024-03-28 13:00:00', 'Train', 60, 30.00),
(8, 6, '2024-03-28 14:00:00', 'Bus', 25, 12.50),
(9, 1, '2024-03-28 15:00:00', 'Plane', 80, 80.00),
(4, 7, '2024-03-28 16:00:00', 'Train', 70, 35.00),
(10, 10, '2024-03-28 17:00:00', 'Bus', 35, 17.50);

INSERT INTO Passenger (Username, Password) 
VALUES 
('user1', 'password1'),
('user2', 'password2'),
('user3', 'password3'),
('user4', 'password4'),
('user5', 'password5'),
('user6', 'password6'),
('user7', 'password7'),
('user8', 'password8'),
('user9', 'password9'),
('user10', 'password10');

INSERT INTO Takes (PassengerID, RouteID) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7),
(8, 8),
(9, 9),
(10, 10);


INSERT INTO Bikes (CurrentLocation, Available) 
VALUES 
('123 Main St', true),
('456 Elm St', true),
('789 Oak St', true),
('101 Maple St', true),
('111 Pine St', true),
('222 Cedar St', true),
('333 Walnut St', true),
('444 Birch St', true),
('555 Cherry St', true),
('777 Willow St', true);



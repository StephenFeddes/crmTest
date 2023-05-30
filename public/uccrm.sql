CREATE TABLE ticket(
    ticketId INT AUTO_INCREMENT,
    title VARCHAR(255),
    assigned_to_id INT,
    status VARCHAR(255),
    priority VARCHAR(255),
    created DATETIME,
    PRIMARY KEY (ticketId),
    FOREIGN KEY (assigned_to_id) REFERENCES employee(id)
);
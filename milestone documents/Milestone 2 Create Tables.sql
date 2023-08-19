CREATE TABLE Project(
	ProjectID char(11),
	Name char(50),
	Description char(255),
	Status char(11),
	PRIMARY KEY (ProjectID)
);

CREATE TABLE AppUser(
	UserID char(11),
	Name char(50),
	Email char(50) UNIQUE,
	Password char(50),
	Bio char(255),
	PRIMARY KEY (UserID)
);

CREATE TABLE Team(
	Name char(50),
	MaxCapacity int,
	ProjectID char(11),
	PRIMARY KEY (Name, ProjectID),
	FOREIGN KEY (ProjectID) REFERENCES Project (ProjectID)
		ON DELETE CASCADE
);

CREATE TABLE Role(
	RoleName char(25),
	PRIMARY KEY (RoleName)
);
CREATE TABLE Post(
	PostID char(11),
	Title char(50),
	Description char(255),
	Time date,
	UserID char(11) NOT NULL,
	ProjectID char(11) NOT NULL UNIQUE,
	PRIMARY KEY(PostID),
	FOREIGN KEY (UserID) REFERENCES AppUser (UserID),
		ON DELETE CASCADE
	FOREIGN KEY (ProjectID) REFERENCES Project (ProjectID)
		ON DELETE CASCADE
);
CREATE TABLE Bug(
	BugID char(11),
	Title char(50),
	Status char(11),
	Description char(255),
	Severity char(11),
	StepsToReproduce char(255),
	UserID char(11),
	RoleName char(25),
	ProjectID char(11) NOT NULL,
	PRIMARY KEY (BugID),
	FOREIGN KEY (UserID) REFERENCES AppUser (UserID),
	FOREIGN KEY (RoleName) REFERENCES Role (RoleName),
	FOREIGN KEY (ProjectID) REFERENCES Project (ProjectID)
);
CREATE TABLE Testing(
	TestingID char(11),
	Title char(11),
	Description char(255),
	Environment char(11),
	Coverage int,
	UserID char(11),
	RoleName char(25),
	ProjectID char(11) NOT NULL,
	PRIMARY KEY (TestingID),
	FOREIGN KEY (UserID) REFERENCES AppUser (UserID),
	FOREIGN KEY (RoleName) REFERENCES Role (RoleName),
	FOREIGN KEY (ProjectID) REFERENCES Project (ProjectID)
);
CREATE TABLE TestingCoverageStatusMap(
	Coverage int,
	Status char(11),
	PRIMARY KEY (Coverage)
);
CREATE TABLE Feature(
	FeatureID char(11),
	Title char(50),
	Status char(11),
	Description char(255),
	AcceptanceCriteria char(255),
	UserID char(11),
	RoleName char(25),
	ProjectID char(11) NOT NULL,
	PRIMARY KEY (FeatureID),
	FOREIGN KEY (UserID) REFERENCES AppUser (UserID),
	FOREIGN KEY (RoleName) REFERENCES Role (RoleName),
	FOREIGN KEY (ProjectID) REFERENCES Project (ProjectID)
);
CREATE TABLE Security(
	SecurityID char(11),
	Title char(50),
	Status char(11),
	Description char(255),
	CVSS decimal(3,1),
	UserID char(11),
	RoleName char(25),
	ProjectID char(11) NOT NULL,
	PRIMARY KEY (SecurityID),
	FOREIGN KEY (UserID) REFERENCES AppUser (UserID),
	FOREIGN KEY (RoleName) REFERENCES Role (RoleName),
	FOREIGN KEY (ProjectID) REFERENCES Project (ProjectID)
);
CREATE TABLE SecurityCVSSSeverityMap(
	CVSS decimal(3,1),
	Severity char(11),
	PRIMARY KEY (CVSS)
);
CREATE TABLE Notification(
	NotificationID char(11),
	Type char(11),
	Time date,
	ReviewingUserID char(11) NOT NULL,
	PRIMARY KEY (NotificationID),
	FOREIGN KEY (ReviewingUserID) REFERENCES AppUser (UserID)
);
CREATE TABLE RequestToJoin(
	RequestID char(11),
	Status char(11),
	Time date,
	ProjectID char(11) NOT NULL,
	NotificationID char(11) NOT NULL UNIQUE,
	RequestingUserID char(11) NOT NULL,
	PRIMARY KEY (RequestID),
	FOREIGN KEY (ProjectID) REFERENCES Project (ProjectID),
	FOREIGN KEY (NotificationID) REFERENCES Notification (NotificationID),
	FOREIGN KEY (RequestingUserID) REFERENCES AppUser (UserID)
);
CREATE TABLE NotificationTypeDescMap(
	Type char(11),
	Description char(255),
	PRIMARY KEY (Type)
);
CREATE TABLE UserHasRole(
	UserID char(11),
	RoleName char(25),
	PRIMARY KEY (UserID, RoleName),
	FOREIGN KEY (UserID) REFERENCES AppUser (UserID),
	FOREIGN KEY (RoleName) REFERENCES Role (RoleName)
);
CREATE TABLE PostNeedsRole(
	PostID char(11),
	RoleName char(25),
	PRIMARY KEY (PostID, RoleName),
	FOREIGN KEY (PostID) REFERENCES Post (PostID),
	FOREIGN KEY (RoleName) REFERENCES Role (RoleName)
);
CREATE TABLE TeamHasPeople(
	ProjectID char(11),
	TeamName char(50),
	RoleName char(25),
	UserID char(11),
	PRIMARY KEY (ProjectID, TeamName, RoleName, UserID),
	FOREIGN KEY (ProjectID) REFERENCES Project (ProjectID),
	FOREIGN KEY (TeamName) REFERENCES Team (Name),
	FOREIGN KEY (RoleName) REFERENCES Role (RoleName),
	FOREIGN KEY (UserID) REFERENCES AppUser (UserID)
);

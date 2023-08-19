<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PbSeeder extends Seeder
{
    public function run()
    {
        // Creating tables if they don't exist
        $this->db->query('CREATE TABLE IF NOT EXISTS Project(
	                        ProjectID int AUTO_INCREMENT ,
	                        Name char(50),
	                        Description char(255),
	                        Status char(11),
	                        PRIMARY KEY (ProjectID)
                            );
                            ');
        $this->db->query('CREATE TABLE IF NOT EXISTS AppUser(
	                        UserID int AUTO_INCREMENT,
	                        Name char(50),
	                        Email char(50) UNIQUE,
	                        Password char(50),
	                        Bio char(255),
	                        PRIMARY KEY (UserID)
                            );
                            ');
        $this->db->query('CREATE TABLE IF NOT EXISTS Team(
	                        Name char(50),
	                        MaxCapacity int,
	                        ProjectID int,
	                        PRIMARY KEY (Name, ProjectID),
	                        FOREIGN KEY (ProjectID) REFERENCES Project (ProjectID)
	                        	ON DELETE CASCADE
                            );
                            ');
        $this->db->query('CREATE TABLE IF NOT EXISTS Role(
                        	RoleName char(25),
                        	PRIMARY KEY (RoleName)
                            );
                            ');
        $this->db->query('CREATE TABLE IF NOT EXISTS Post(
	                        PostID int AUTO_INCREMENT ,
	                        Title char(50),
	                        Description char(255),
	                        Time date,
	                        UserID int,
	                        ProjectID int NOT NULL UNIQUE,
	                        PRIMARY KEY(PostID),
	                        FOREIGN KEY (UserID) REFERENCES AppUser (UserID)
	                        	ON DELETE SET NULL,
	                        FOREIGN KEY (ProjectID) REFERENCES Project (ProjectID)
	                        	ON DELETE CASCADE
                            );
                            ');
        $this->db->query('CREATE TABLE IF NOT EXISTS Task(
                            TaskID int AUTO_INCREMENT,
                            Title char(50),
                            Description char(255),
                            PRIMARY KEY (TaskID)
                            );
                            ');
        $this->db->query('CREATE TABLE IF NOT EXISTS Bug(
	                        BugID int,
	                        Status char(11),
	                        Severity char(11),
	                        StepsToReproduce char(255),
	                        UserID int,
	                        RoleName char(25),
	                        ProjectID int NOT NULL,
	                        PRIMARY KEY (BugID),
                            FOREIGN KEY (BugID) REFERENCES Task (TaskID),
	                        FOREIGN KEY (UserID) REFERENCES AppUser (UserID)
                                ON DELETE SET NULL,
	                        FOREIGN KEY (RoleName) REFERENCES Role (RoleName),
	                        FOREIGN KEY (ProjectID) REFERENCES Project (ProjectID)
                                ON DELETE CASCADE
                            );
                            ');
        $this->db->query('CREATE TABLE IF NOT EXISTS TestingCoverageStatusMap(
	                        Coverage int,
	                        Status char(11),
	                        PRIMARY KEY (Coverage)
                            );
                            ');
        $this->db->query('CREATE TABLE IF NOT EXISTS Feature(
	                        FeatureID int,
	                        Status char(11),
	                        AcceptanceCriteria char(255),
	                        UserID int,
	                        RoleName char(25),
	                        ProjectID int NOT NULL,
	                        PRIMARY KEY (FeatureID),
                            FOREIGN KEY (FeatureID) REFERENCES Task (TaskID),
	                        FOREIGN KEY (UserID) REFERENCES AppUser (UserID)
                                ON DELETE SET NULL,
	                        FOREIGN KEY (RoleName) REFERENCES Role (RoleName),
	                        FOREIGN KEY (ProjectID) REFERENCES Project (ProjectID)
                                ON DELETE CASCADE
                            );
                            ');
        $this->db->query('CREATE TABLE IF NOT EXISTS Testing(
	                        TestingID int,
	                        Environment char(11),
	                        Coverage int,
	                        UserID int ,
	                        RoleName char(25),
	                        ProjectID int NOT NULL,
	                        PRIMARY KEY (TestingID),
                            FOREIGN KEY (TestingID) REFERENCES Task (TaskID),
	                        FOREIGN KEY (UserID) REFERENCES AppUser (UserID)
                                ON DELETE SET NULL,
	                        FOREIGN KEY (RoleName) REFERENCES Role (RoleName),
	                        FOREIGN KEY (ProjectID) REFERENCES Project (ProjectID)
                                ON DELETE CASCADE
                            );
                            ');
        $this->db->query('CREATE TABLE IF NOT EXISTS Security(
	                        SecurityID int,
	                        Status char(11),
	                        CVSS decimal(3,1),
	                        UserID int,
	                        RoleName char(25),
	                        ProjectID int NOT NULL ,
	                        PRIMARY KEY (SecurityID),
                            FOREIGN KEY (SecurityID) REFERENCES Task (TaskID),
	                        FOREIGN KEY (UserID) REFERENCES AppUser (UserID)
                                ON DELETE SET NULL,
	                        FOREIGN KEY (RoleName) REFERENCES Role (RoleName),
	                        FOREIGN KEY (ProjectID) REFERENCES Project (ProjectID)
                                ON DELETE CASCADE
                            );
                            ');
        $this->db->query('CREATE TABLE IF NOT EXISTS SecurityCVSSSeverityMap(
	                        CVSS decimal(3,1),
	                        Severity char(11),
	                        PRIMARY KEY (CVSS)
                            );
                            ');
        $this->db->query('CREATE TABLE IF NOT EXISTS Notification(
	                        NotificationID int AUTO_INCREMENT ,
	                        Type char(11),
	                        Time date,
	                        ReviewingUserID int,
	                        PRIMARY KEY (NotificationID),
	                        FOREIGN KEY (ReviewingUserID) REFERENCES AppUser (UserID)
                                ON DELETE SET NULL
                            );
                            ');
        $this->db->query('CREATE TABLE IF NOT EXISTS RequestToJoin(
	                        RequestID int AUTO_INCREMENT,
	                        Status char(11),
	                        Time date,
	                        ProjectID int  NOT NULL,
	                        NotificationID int NOT NULL UNIQUE,
	                        RequestingUserID int,
	                        PRIMARY KEY (RequestID),
	                        FOREIGN KEY (ProjectID) REFERENCES Project (ProjectID)
                                ON DELETE CASCADE,
	                        FOREIGN KEY (NotificationID) REFERENCES Notification (NotificationID),
	                        FOREIGN KEY (RequestingUserID) REFERENCES AppUser (UserID)
                                ON DELETE SET NULL
                            );
                            ');
        $this->db->query('CREATE TABLE IF NOT EXISTS NotificationTypeDescMap(
	                        Type char(11),
	                        Description char(255),
	                        PRIMARY KEY (Type)
                            );
                            ');
        $this->db->query('CREATE TABLE IF NOT EXISTS UserHasRole(
	                        UserID int ,
	                        RoleName char(25),
	                        PRIMARY KEY (UserID, RoleName),
	                        FOREIGN KEY (UserID) REFERENCES AppUser (UserID)
                                ON DELETE CASCADE,
	                        FOREIGN KEY (RoleName) REFERENCES Role (RoleName)
                            );
                            ');
        $this->db->query('CREATE TABLE IF NOT EXISTS PostNeedsRole(
	                        PostID int ,
	                        RoleName char(25),
	                        PRIMARY KEY (PostID, RoleName),
	                        FOREIGN KEY (PostID) REFERENCES Post (PostID)
                                ON DELETE CASCADE,
	                        FOREIGN KEY (RoleName) REFERENCES Role (RoleName)
                            );
                            ');
        $this->db->query('CREATE TABLE IF NOT EXISTS TeamHasPeople(
	                        ProjectID int ,
	                        TeamName char(50),
	                        RoleName char(25),
	                        UserID int  ,
	                        PRIMARY KEY (ProjectID, TeamName, RoleName, UserID),
	                        FOREIGN KEY (ProjectID) REFERENCES Project (ProjectID)
                                ON DELETE CASCADE,
	                        FOREIGN KEY (TeamName) REFERENCES Team (Name)
                                ON DELETE CASCADE,
	                        FOREIGN KEY (RoleName) REFERENCES Role (RoleName),
	                        FOREIGN KEY (UserID) REFERENCES AppUser (UserID)
                                ON DELETE CASCADE
                            );
                            ');

        // Inserting Mapping Data
        $this->db->query('INSERT INTO NotificationTypeDescMap(Type, Description)
                             VALUES
                             ("Request", "A user has requested to join your team!"),
                             ("Approval", "Your request to join a team has been approved!"),
                             ("Denial", "Your request to join a team has been denied."),
                             ("Addition", "A new user joined your team!"),
                             ("Deletion", "A user has left your team.");');

        $this->db->query('INSERT INTO SecurityCvssSeverityMap(CVSS, Severity)
                             VALUES
                             (0.0, "Low"),
                             (0.1, "Low"),
                             (0.2, "Low"),
                             (0.3, "Low"),
                             (0.4, "Low"),
                             (0.5, "Low"),
                             (0.6, "Low"),
                             (0.7, "Low"),
                             (0.8, "Low"),
                             (0.9, "Low"),
                             (1.0, "Low"),
                             (1.1, "Low"),
                             (1.2, "Low"),
                             (1.3, "Low"),
                             (1.4, "Low"),
                             (1.5, "Low"),
                             (1.6, "Low"),
                             (1.7, "Low"),
                             (1.8, "Low"),
                             (1.9, "Low"),
                             (2.0, "Low"),
                             (2.1, "Low"),
                             (2.2, "Low"),
                             (2.3, "Low"),
                             (2.4, "Low"),
                             (2.5, "Low"),
                             (2.6, "Low"),
                             (2.7, "Low"),
                             (2.8, "Low"),
                             (2.9, "Low"),
                             (3.0, "Low"),
                             (3.1, "Low"),
                             (3.2, "Low"),
                             (3.3, "Low"),
                             (3.4, "Low"),
                             (3.5, "Low"),
                             (3.6, "Low"),
                             (3.7, "Low"),
                             (3.8, "Low"),
                             (3.9, "Low"),
                             (4.0, "Medium"),
                             (4.1, "Medium"),
                             (4.2, "Medium"),
                             (4.3, "Medium"),
                             (4.4, "Medium"),
                             (4.5, "Medium"),
                             (4.6, "Medium"),
                             (4.7, "Medium"),
                             (4.8, "Medium"),
                             (4.9, "Medium"),
                             (5.0, "Medium"),
                             (5.1, "Medium"),
                             (5.2, "Medium"),
                             (5.3, "Medium"),
                             (5.4, "Medium"),
                             (5.5, "Medium"),
                             (5.6, "Medium"),
                             (5.7, "Medium"),
                             (5.8, "Medium"),
                             (5.9, "Medium"),
                             (6.0, "Medium"),
                             (6.1, "Medium"),
                             (6.2, "Medium"),
                             (6.3, "Medium"),
                             (6.4, "Medium"),
                             (6.5, "Medium"),
                             (6.6, "Medium"),
                             (6.7, "Medium"),
                             (6.8, "Medium"),
                             (6.9, "Medium"),
                             (7.0, "High"),
                             (7.1, "High"),
                             (7.2, "High"),
                             (7.3, "High"),
                             (7.4, "High"),
                             (7.5, "High"),
                             (7.6, "High"),
                             (7.7, "High"),
                             (7.8, "High"),
                             (7.9, "High"),
                             (8.0, "High"),
                             (8.1, "High"),
                             (8.2, "High"),
                             (8.3, "High"),
                             (8.4, "High"),
                             (8.5, "High"),
                             (8.6, "High"),
                             (8.7, "High"),
                             (8.8, "High"),
                             (8.9, "High"),
                             (9.0, "Critical"),
                             (9.1, "Critical"),
                             (9.2, "Critical"),
                             (9.3, "Critical"),
                             (9.4, "Critical"),
                             (9.5, "Critical"),
                             (9.6, "Critical"),
                             (9.7, "Critical"),
                             (9.8, "Critical"),
                             (9.9, "Critical"),
                             (10.0, "Critical");');

        $this->db->query('INSERT INTO TestingCoverageStatusMap(Coverage, Status)
                             VALUES
                             (0, "open"),
                             (1, "in progress"),
                             (2, "in progress"),
                             (3, "in progress"),
                             (4, "in progress"),
                             (5, "in progress"),
                             (6, "in progress"),
                             (7, "in progress"),
                             (8, "in progress"),
                             (9, "in progress"),
                             (10, "in progress"),
                             (11, "in progress"),
                             (12, "in progress"),
                             (13, "in progress"),
                             (14, "in progress"),
                             (15, "in progress"),
                             (16, "in progress"),
                             (17, "in progress"),
                             (18, "in progress"),
                             (19, "in progress"),
                             (20, "in progress"),
                             (21, "in progress"),
                             (22, "in progress"),
                             (23, "in progress"),
                             (24, "in progress"),
                             (25, "in progress"),
                             (26, "in progress"),
                             (27, "in progress"),
                             (28, "in progress"),
                             (29, "in progress"),
                             (30, "in progress"),
                             (31, "in progress"),
                             (32, "in progress"),
                             (33, "in progress"),
                             (34, "in progress"),
                             (35, "in progress"),
                             (36, "in progress"),
                             (37, "in progress"),
                             (38, "in progress"),
                             (39, "in progress"),
                             (40, "in progress"),
                             (41, "in progress"),
                             (42, "in progress"),
                             (43, "in progress"),
                             (44, "in progress"),
                             (45, "in progress"),
                             (46, "in progress"),
                             (47, "in progress"), 
                             (48, "in progress"), 
                             (49, "in progress"), 
                             (50, "in progress"), 
                             (51, "in progress"),
                             (52, "in progress"),
                             (53, "in progress"),
                             (54, "in progress"),
                             (55, "in progress"),
                             (56, "in progress"),
                             (57, "in progress"),
                             (58, "in progress"),
                             (59, "in progress"),
                             (60, "in progress"),
                             (61, "in progress"),
                             (62, "in progress"),
                             (63, "in progress"),
                             (64, "in progress"),
                             (65, "in progress"),
                             (66, "in progress"),
                             (67, "in progress"),
                             (68, "in progress"),
                             (69, "in progress"),
                             (70, "in progress"),
                             (71, "in progress"),
                             (72, "in progress"),
                             (73, "in progress"),
                             (74, "in progress"),
                             (75, "in progress"),
                             (76, "in progress"),
                             (77, "in progress"),
                             (78, "in progress"),
                             (79, "in progress"),
                             (80, "in progress"),
                             (81, "in progress"),
                             (82, "in progress"),
                             (83, "in progress"),
                             (84, "in progress"),
                             (85, "in progress"),
                             (86, "in progress"),
                             (87, "in progress"),
                             (88, "in progress"),
                             (89, "in progress"),
                             (90, "in progress"),
                             (91, "in progress"),
                             (92, "in progress"),
                             (93, "in progress"),
                             (94, "in progress"),
                             (95, "in progress"),
                             (96, "in progress"),
                             (97, "in progress"),
                             (98, "in progress"),
                             (99, "in progress"),
                             (100, "closed");');

        $this->db->query('INSERT INTO Role(RoleName) 
                            VALUES 
                            ("Frontend Developer"),
                            ("Backend Developer"),
                            ("Designer"),
                            ("Project Manager"),
                            ("QA");');

        // Inserting dummy data
        $this->db->query('INSERT INTO Project(ProjectID, Name, Description, Status) 
                            VALUES 
                            (1, "This is a project", "Random project", "in progress"),
                            (2, "Twitter", "This is project for creating Twitter", "completed"),
                            (3, "Instagram", "Internal server building", "in progress"),
                            (4, "SpaceX", "Rocket design and coding", "in progress"),
                            (5, "BC Hydro", "Infrustructure of BC hydro", "in progress");');

        $this->db->query('INSERT INTO AppUser(UserID, Name, Email, Password, Bio) 
                            VALUES 
                            (1, "Kutluay Cakadur", "test@gmail.com", "test", "I code babygirl."),
                            (2, "Selin Uz", "selinuz@gmail.com", "S34D765VHAJW0", "Hey, I focus on backend and cook!"),
                            (3, "Irmak Bayir", "anan@gmail.com", "mlnkbhj4365", "Wazzup"),
                            (4, "Gittu George",	"gittugeorge@gmail.com",	"ladfjn92o2bmfa",	"Professor at UBC"),
                            (5,	"Jason Hall", "jasonhall@gmail.com",	"325ljbkw425k",	"Hi, Im a cool TA."); ');

        $this->db->query(' INSERT INTO Post(PostID, Title, Description, Time, UserID, ProjectID) 
                            VALUES 
                            (1, "Looking for partners on Project 1!", "Hi all, I want to find partners for my project :)", "2023-03-01", 1, 1),
                            (2, "In need of developers", "Hello everyone, is there anyone here with experience in developing in C# for the below project?", "2023-01-04", 1, 2),
                            (3, "Help", "URGENT! I NEED A UI DESIGNER FOR A PROJECT ABOUT BC HYDRO", "2023-05-01", 2, 3),
                            (4, "Developers for Instagram Project?", "If you have worked with Javascript and have 3 years of experience, please hmu.", "2023-07-01", 1, 4),
                            (5, "UI Designer needed", "Want to work on SpaceX?", "2023-07-01", 3, 5); ');

        $this->db->query('INSERT INTO Team(Name, MaxCapacity, ProjectID) 
                            VALUES 
                            ("eagles", 3, 3),
                            ("lions", 4, 1),
                            ("raptors", 5, 2),
                            ("alpha", 6, 4),
                            ("bravo", 7, 5);  ');

        $this->db->query('INSERT INTO Task(TaskID, Title, Description) 
                            VALUES 
                            (1, "unending promise", "a"),
                            (2, "cannot see button", "b"),
                            (3, "filter not working", "c"),
                            (4, "bug in main branch", "d"),
                            (5, "for loop doesnt index through last item in list", "2"),
                            (6, "Testing", "Testing a"),
                            (7, "Testing", "Testing b"),
                            (8, "Testing", "Testing c"),
                            (9, "Testing", "Testing d"),
                            (10, "Testing", "Testing e"),
                            (11, "feature", "feature"),
                            (12, "feature", "feature"),
                            (13, "feature", "feature"),
                            (14, "feature", "feature"),
                            (15, "feature", "feature"),
                            (16, "security vulnerability with dependency", "Security"),
                            (17, "security scan warning", "Security"),
                            (18, "security vulnerability", "Security"),
                            (19, "dependency has vulnerability", "Security"),
                            (20, "need to update dependency", "Security");');

        $this->db->query('INSERT INTO Bug(BugID, Status, Severity, StepsToReproduce, UserID, RoleName, ProjectID) 
                            VALUES 
                            (1, "in progress", "high", "a", 1, "Backend Developer", 1),
                            (2, "open", "medium", "b", 3, "Frontend Developer",	3),
                            (3,	"closed",	"low",	"c", 1,	"Frontend Developer",	2),
                            (4,	"in progress",	"high",	"d",	1,	"Backend Developer",	5),
                            (5,	"in progress",	"high",	"e",	1,	"Backend Developer", 4);');

        $this->db->query('INSERT INTO Testing(TestingID,	Environment,	Coverage,	UserID,	RoleName,	ProjectID) 
                            VALUES 
                            (6,	"Staging",	50,	2,	"QA",	5),
                            (7,	"Prod",	0,	2,	"QA",	5),
                            (8,	"Dev",	75,	2,	"QA",	5),
                            (9,	"Prod",	100,	2,	"QA",	5),
                            (10, "Dev",	25,	2,	"QA",	5); ');

        $this->db->query('INSERT INTO Feature(FeatureID,	Status,	AcceptanceCriteria,	UserID,	RoleName,	ProjectID) 
                            VALUES 
                            (11, "open",	"some criteria",	4,	"Backend Developer",	4),
                            (12, "open",	"some criteria",	4,	"Backend Developer",	4),
                            (13, "in progress",	"some criteria",	4,	"Backend Developer",	4),
                            (14, "in progress",	"some criteria",	4,	"Backend Developer",	4),
                            (15, "closed",	"some criteria",	1,	"Backend Developer",	1); ');

        $this->db->query('INSERT INTO Security(SecurityID,	Status,	CVSS,	UserID,	RoleName,	ProjectID) 
                            VALUES 
                            (16, "in progress",	1.1, 5,	"Backend Developer",	5),
                            (17, "open", 2.3, 5,	"Backend Developer",	5),
                            (18, "closed", 4.1,	5, "Backend Developer",	5),
                            (19, "in progress",	6.5,	5,	"Backend Developer",	5),
                            (20, "in progress",	9.4,	5,	"Backend Developer",	5);  ');

        $this->db->query('INSERT INTO Notification(NotificationID,	Type,	Time,	ReviewingUserID) 
                            VALUES 
                            (1,	"request",	"2023-01-01",	1),
                            (2,	"deletion",	"2023-01-02",	1),
                            (3,	"addition",	"2023-01-03",	1),
                            (4,	"approval",	"2023-01-04",	1),
                            (5,	"denial",	"2023-01-05",	3);  ');

        $this->db->query('INSERT INTO RequestToJoin(RequestID,	Status,	Time,	ProjectID,	NotificationID,	RequestingUserID) 
                            VALUES 
                            (1,	"approved",	"2023-01-03",	5,	1, 5),
                            (2,	"approved",	"2023-01-04",	4,	2,	4),
                            (3,	"approved",	"2023-01-01",	1,	3,	3),
                            (4,	"approved",	"2023-01-05",	5,	4,	2),
                            (5,	"denied",	"2023-01-07",	1,	5,	5); ');

        $this->db->query('INSERT INTO UserHasRole(UserID,	RoleName) 
                            VALUES 
                            (1,	"Designer"),
                            (1,	"Frontend Developer"),
                            (1,	"Backend Developer"),
                            (2,	"QA"),
                            (3,	"Frontend Developer"),
                            (4,	"Backend Developer"),
                            (5,	"Project Manager");  ');

        $this->db->query('INSERT INTO PostNeedsRole(PostID,	RoleName) 
                            VALUES 
                            (1,	"QA"),
                            (2,	"Frontend Developer"),
                            (3,	"Designer"),
                            (4,	"Project Manager"),
                            (5,	"Backend Developer"); ');

        $this->db->query('INSERT INTO TeamHasPeople(ProjectID,	TeamName,	RoleName,	UserID) 
                            VALUES 
                                (3,	"eagles", "Frontend Developer",	3),
                                (1,	"lions", "Backend Developer",	4),
                                (2,	"raptors",	"Designer",	1),
                                (4,	"alpha",	"Project Manager",	5),
                                (5,	"bravo",	"QA",	2);  ');
    }
}

INSERT INTO Project(ProjectID, Name, Description, Status) 
    VALUES 
    ("000-000-001", "This is a project", "Random project", "in progress"),
    ("000-000-002", "Twitter", "This is project for creating Twitter", "completed"),
    ("000-000-003", "Instagram", "Internal server building", "in progress"),
    ("000-000-004", "SpaceX", "Rocket design and coding", "in progress"),
    ("000-000-005", "BC Hydro", "Infrustructure of BC hydro", "in progress");

INSERT INTO AppUser(UserID, Name, Email, Password, Bio) 
    VALUES 
    ("000-000-001", "Kutluay Cakadur", "kutluaycakadur@gmail.com", "1234d567890", "I code babygirl"),
    ("000-000-002", "Selin Uz", "selinuz@gmail.com", "S34D765VHAJW0", "Hey, I focus on backend and cook!"),
    ("000-000-003", "Irmak Bayir", "anan@gmail.com", "mlnkbhj4365", "Wazzup"),
    ("000-000-004", "Gittu George",	"gittugeorge@gmail.com",	"ladfjn92o2bmfa",	"Professor at UBC"),
    ("000-000-005",	"Jason Hall", "jasonhall@gmail.com",	"325ljbkw425k",	"Hi, I'm a cool TA.");
    
INSERT INTO Post(PostID, Title, Description, Time, UserID, ProjectID) 
    VALUES 
    ("000-000-001", "Looking for partners on Project 1!", "Hi all, I want to find partners for my project :)", "2023-03-01", "000-000-001", "000-000-001"),
    ("000-000-002", "In need of developers", "Hello everyone, is there anyone here with experience in developing in C# for the below project?", "2023-01-04", "000-000-001", "000-000-002"),
    ("000-000-003", "Help", "URGENT! I NEED A UI DESIGNER FOR A PROJECT ABOUT BC HYDRO", "2023-05-01", "000-000-002", "000-000-003"),
    ("000-000-004", "Developers for Instagram Project?", "If you have worked with Javascript and have 3 years of experience, please hmu.", "2023-09-01", "000-000-001", "000-000-004"),
    ("000-000-005", "UI Designer needed", "Want to work on SpaceX?", "2023-07-01", "000-000-003", "000-000-005");

INSERT INTO Team(Name, MaxCapacity, ProjectID) 
    VALUES 
    ("eagles", 3, "000-000-003"),
    ("lions", 4, "000-000-001"),
    ("raptors", 5, "000-000-002"),
    ("alpha", 6, "000-000-004"),
    ("bravo", 7, "000-000-005");

INSERT INTO Bug(BugID, Title, Status, Severity, Description, StepsToReproduce, UserID, RoleName, ProjectID) 
    VALUES 
    ("000-000-001", "unending promise", "in progress", "high", "a", "a", "000-000-001", "Backend Developer", "000-000-001"),
    ("000-000-002", "cannot see button", "open", "medium", "b", "b", "000-000-003", "Frontend Developer",	"000-000-003"),
    ("000-000-003",	"filter not working",	"closed",	"low",	"c",	"c", "000-000-001",	"Backend Developer",	"000-000-002"),
    ("000-000-004",	"bug in main branch",	"in progress",	"high",	"d",	"d",	"000-000-001",	"Backend Developer",	"000-000-005"),
    ("000-000-005",	"for loop doesn't index through last item in list",	"in progress",	"high",	"e", "e",	"000-000-001",	"Backend Developer", "000-000-004");

INSERT INTO Testing(TestingID,	Title,	Description,	Environment,	Coverage,	UserID,	RoleName,	ProjectID) 
    VALUES 
    ("000-000-006",	"Testing",	"Testing a",	"Staging",	50,	"000-000-002",	"QA",	"000-000-005"),
    ("000-000-007",	"Testing",	"Testing b",	"Prod",	25,	"000-000-002",	"QA",	"000-000-005"),
    ("000-000-008",	"Testing",	"Testing c",	"Dev",	75,	"000-000-002",	"QA",	"000-000-005"),
    ("000-000-009",	"Testing",	"Testing d",	"Prod",	100,	"000-000-002",	"QA",	"000-000-005"),
    ("000-000-010",	"Testing",	"Testing e",	"Dev",	25,	"000-000-002",	"QA",	"000-000-005");

INSERT INTO Feature(FeatureID,	Title,	Status,	Description,	AcceptanceCriteria,	UserID,	RoleName,	ProjectID) 
    VALUES 
    ("000-000-011",	"feature",	"open",	"feature",	"some criteria",	"000-000-004",	"Backend Developer",	"000-000-004"),
    ("000-000-012",	"feature",	"open",	"feature",	"some criteria",	"000-000-004",	"Backend Developer",	"000-000-004"),
    ("000-000-013",	"feature",	"in progress",	"feature",	"some criteria",	"000-000-004",	"Backend Developer",	"000-000-004"),
    ("000-000-014",	"feature",	"in progress",	"feature",	"some criteria",	"000-000-004",	"Backend Developer",	"000-000-004"),
    ("000-000-015",	"feature",	"closed",	"feature",	"some criteria",	"000-000-004",	"Backend Developer",	"000-000-004");

INSERT INTO Security(SecurityID,	Title,	Status,	Description,	CVSS,	UserID,	RoleName,	ProjectID) 
    VALUES 
    ("000-000-016",	"security vulnerability with dependency",	"in progress",	"Security",	1.1,	"000-000-005",	"Backend Developer",	"000-000-005"),
    ("000-000-017",	"security scan warning",	"open",	"Security",	2.3,	"000-000-005",	"Backend Developer",	"000-000-005"),
    ("000-000-018",	"security vulnerability",	"closed",	"Security",	4.1,	"000-000-005",	"Backend Developer",	"000-000-005"),
    ("000-000-019",	"dependency has vulnerability",	"in progress",	"Security",	6.5,	"000-000-005",	"Backend Developer",	"000-000-005"),
    ("000-000-020",	"need to update dependency",	"in progress",	"Security",	9.4,	"000-000-005",	"Backend Developer",	"000-000-005");

INSERT INTO Notification(NotificationID,	Type,	Time,	ReviewingUserID) 
    VALUES 
    ("000-000-001",	"request",	"2023-01-01",	"000-000-001"),
    ("000-000-002",	"deletion",	"2023-01-02",	"000-000-001"),
    ("000-000-003",	"addition",	"2023-01-03",	"000-000-001"),
    ("000-000-004",	"approval",	"2023-01-04",	"000-000-001"),
    ("000-000-005",	"denial",	"2023-01-05",	"000-000-003");
    
INSERT INTO RequestToJoin(RequestID,	Status,	Time,	ProjectID,	NotificationID,	RequestingUserID) 
    VALUES 
    ("000-000-001",	"approved",	"2023-01-03",	"000-000-005",	"000-000-001", "000-000-005"),
    ("000-000-002",	"approved",	"2023-01-04",	"000-000-004",	"000-000-002",	"000-000-004"),
    ("000-000-003",	"approved",	"2023-01-01",	"000-000-001",	"000-000-003",	"000-000-003"),
    ("000-000-004",	"approved",	"2023-01-05",	"000-000-005",	"000-000-004",	"000-000-002"),
    ("000-000-005",	"denied",	"2023-01-07",	"000-000-001",	"000-000-005",	"000-000-005");

INSERT INTO UserHasRole(UserID,	RoleName) 
    VALUES 
    ("000-000-001",	"Designer"),
    ("000-000-002",	"QA"),
    ("000-000-003",	"Frontend Developer"),
    ("000-000-004",	"Backend Developer"),
    ("000-000-005",	"Project Manager");

INSERT INTO PostNeedsRole(PostID,	RoleName) 
    VALUES 
    ("000-000-001",	"QA"),
    ("000-000-002",	"Frontend Developer"),
    ("000-000-003",	"Designer"),
    ("000-000-004",	"Project Manager"),
    ("000-000-005",	"Backend Developer");

INSERT INTO TeamHasPeople(ProjectID,	TeamName,	RoleName,	UserID) 
    VALUES 
    ("000-000-003",	"eagles", "Frontend Developer",	"000-000-003"),
    ("000-000-001",	"lions", "Backend Developer",	"000-000-004"),
    ("000-000-002",	"raptors",	"Designer",	"000-000-001"),
    ("000-000-004",	"alpha",	"Project Manager",	"000-000-005"),
    ("000-000-005",	"bravo",	"QA",	"000-000-002");
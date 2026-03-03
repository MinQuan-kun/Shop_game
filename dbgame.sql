CREATE DATABASE IF NOT EXISTS Game_Store;
USE Game_Store;

CREATE TABLE Accounts (
    UserId INT PRIMARY KEY AUTO_INCREMENT,
    UserName VARCHAR(255) NOT NULL,
    UserPassword VARCHAR(255) NOT NULL,
    UserEmail VARCHAR(255) NOT NULL UNIQUE,
    UserAvatar VARCHAR(255) NULL,
    UserRole VARCHAR(50) DEFAULT 'user',
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UpdatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE Category (
    CategoryId INT PRIMARY KEY AUTO_INCREMENT,
    TagName VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE Games (
    GameId INT PRIMARY KEY AUTO_INCREMENT,
    GameName VARCHAR(255) NOT NULL,
    GameTags VARCHAR(255) NOT NULL,
    GameImage VARCHAR(255) NULL,
    GameLink VARCHAR(255) NOT NULL,
    GameType VARCHAR(100) DEFAULT 'popular'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE Orders (
    OrderId INT PRIMARY KEY AUTO_INCREMENT,
    UserId INT NOT NULL,
    TotalPrice DECIMAL(10,2) NOT NULL,
    Status VARCHAR(50) DEFAULT 'pending',
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UpdatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE OrderItems (
    OrderItemId INT PRIMARY KEY AUTO_INCREMENT,
    OrderId INT NOT NULL,
    GameId INT NOT NULL,
    Price DECIMAL(10,2) NOT NULL,
    Quantity INT DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dữ liệu mẫu users
INSERT INTO Accounts (UserName, UserEmail, UserPassword, UserRole) VALUES
('kusogaki', 'votanbao1912@gmail.com', '0192023a7bbd73250516f069df18b500', 'admin'),
('chimchichchoe', 'chimhoinon@gmail.com', '6ad14ba9986e3615423dfca256d04e3f', 'user'),
('dangkhoa', 'dankkoa@gmail.com', 'c4cefc53ca414d25294fd23b8fccd356', 'admin');

-- Dữ liệu mẫu Category
INSERT INTO Category (TagName) VALUES
('Action'),
('Adventure'),
('Eroge'),
('FPS'),
('Horror'),
('Puzzle'),
('Rhythm'),
('RPG'),
('Simulator'),
('Sport'),
('Strategy'),
('Survival');

-- Dữ liệu mẫu Games
INSERT INTO Games (GameName, GameTags, GameImage, GameLink, GameType) VALUES
('Elden Ring', 'Adventure', 'https://i.imgur.com/q3mbLGE.png', 'EldenRing', 'trend'),
('Ghost of Tsushima', 'RPG', 'https://i.imgur.com/9XxuFVt.png', 'GOT', 'trend'),
('Metal Gear Rising: Revengeance', 'RPG', 'https://i.imgur.com/VyUTwW4.png', 'MGR', 'trend'),
('The Last Of Us', 'RPG', 'https://i.imgur.com/MWwjehp.png', 'TLOU', 'popular'),
('UNCHARTED 4', 'RPG', 'https://i.imgur.com/xbSXYt2.png', 'U4', 'popular'),
('Assasin Creed: Rogue', 'Action', 'https://i.imgur.com/uyKW6NR.png', 'AScreed', 'popular'),
('UnderTale', 'RPG', 'https://i.imgur.com/HTAJINb.png', 'Undertale', 'popular'),
('Deltarune', 'RPG', 'https://i.imgur.com/gIUHPgb.png', 'Deltarune', 'popular'),
('MegamanX', 'Action', 'https://i.imgur.com/n93bZx2.png', 'Mgman', 'popular'),
('Guilty Gear X2', 'Action', 'https://i.imgur.com/RQkR0SJ.png', 'GGXX', 'popular'),
('Portal 2', 'Puzzle', 'https://i.imgur.com/eUPTL5u.png', '', 'popular'),
('Muse Dash', 'Rhythm', 'https://i.imgur.com/xzdGklV.png', '', 'trend'),
('The Pink Poyo~', 'Horror', 'https://i.imgur.com/j2lJxiC.png', '', 'trend'),
('Gunny', 'FPS', 'https://i.imgur.com/RgqnbSN.png', '', 'trend'),
('Contra', 'FPS', 'https://i.imgur.com/1Zju3GQ.png', '', 'trend'),
('Half-life', 'FPS', 'https://i.imgur.com/VCjuqtO.png', '', 'trend'),
('Pokemon Emeral', 'RPG', 'https://i.imgur.com/eAYhVVr.png', '', 'trend'),
('Zingspeed', 'Rhythm', 'https://i.imgur.com/o992lgk.png', '', 'trend'),
('Friday Night Funkin', 'Rhythm', 'https://i.imgur.com/m8e3chu.png', '', 'popular'),
('Five Nights at Freddy', 'Horror', 'https://i.imgur.com/HH2nQHs.png', '', 'popular'),
('Wii Sport', 'Sport', 'https://i.imgur.com/twzWQZ1.png', '', 'popular'),
('ARKNIGHTS', 'Strategy', 'https://i.imgur.com/5NHpSNo.png', '', 'popular'),
('PowerWash Simulator', 'Simulator', 'https://i.imgur.com/5JQXqP5.png', '', 'popular'),
('HaLo: Combat Evolved', 'FPS', 'https://i.imgur.com/fJo4SP9.png', '', 'popular'),
('We Were Here Together', 'Puzzle', 'https://i.imgur.com/THfvNkG.png', '', 'popular'),
('GTA V', 'RPG', 'https://i.imgur.com/l6JJQav.png', '', 'popular'),
('GTA 4', 'RPG', 'https://i.imgur.com/J6GC7lt.png', '', 'trend'),
('Nino Kuni', 'RPG', 'https://i.imgur.com/AgJl1b4.png', '', 'popular'),
('Hades', 'Action', 'https://i.imgur.com/TBjJATo.png', '', 'popular'),
('Minecraft', 'Horror', 'https://i.imgur.com/8Y45BFA.png', '', 'popular'),
('Ghostrunner', 'Action', 'https://i.imgur.com/SaWlbwG.png', '', 'popular'),
('Oblivion', 'RPG', 'https://i.imgur.com/cvZ7QN6.png', '', 'popular'),
('Skyrim', 'Adventure', 'https://i.imgur.com/OhJJjj5.png', '', 'popular'),
('Farcry 4', 'RPG', 'https://i.imgur.com/w1XO3bR.png', '', 'popular'),
('Outlast', 'Horror', 'https://i.imgur.com/Rz5fkgn.png', '', 'popular'),
('Outlast 2', 'Horror', 'https://i.imgur.com/asaHo0u.png', '', 'popular'),
('Resident Evil 8', 'Action', 'https://i.imgur.com/AC86xbX.png', '', 'popular'),
('Thief Simulator', 'Simulator', 'https://i.imgur.com/OdtcRqF.png', '', 'popular'),
('The forest', 'Horror', 'https://i.imgur.com/DWmwJnR.png', '', 'popular'),
('W2K22', 'Action', 'https://i.imgur.com/Uz4g0Jd.png', '', 'trend'),
('FIFA', 'Sport', 'https://i.imgur.com/J3NEabk.png', '', 'popular'),
('Hero 3', 'Strategy', 'https://i.imgur.com/D9rTnJx.png', '', 'popular'),
('Soulsimp', 'Strategy', 'https://i.imgur.com/KFivDV5.png', '', 'popular');

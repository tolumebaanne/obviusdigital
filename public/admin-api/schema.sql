-- Portfolio admin schema. Run once against the site's MySQL database
-- (via phpMyAdmin or `mysql < schema.sql`) before the admin panel is used.

-- Authorized login emails. The first row you insert should have
-- is_admin = 1 — only admin rows can add or remove other emails from this
-- table; everyone else can log in and manage the portfolio, but not access.
CREATE TABLE IF NOT EXISTS admin_emails (
  id INT PRIMARY KEY AUTO_INCREMENT,
  email VARCHAR(255) NOT NULL UNIQUE,
  is_admin TINYINT(1) NOT NULL DEFAULT 0,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- One row per requested login code. Codes are single-use, short-lived, and
-- capped at 5 guesses (m0t.AUTH.2.5 — Authorization Codes Are Ephemeral).
-- is_admin is a snapshot of the requesting email's privilege at request time.
CREATE TABLE IF NOT EXISTS login_codes (
  id INT PRIMARY KEY AUTO_INCREMENT,
  email VARCHAR(255) NOT NULL,
  is_admin TINYINT(1) NOT NULL DEFAULT 0,
  code_hash VARCHAR(255) NOT NULL,
  attempts INT NOT NULL DEFAULT 0,
  used TINYINT(1) NOT NULL DEFAULT 0,
  expires_at TIMESTAMP NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  ip_address VARCHAR(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Rate-limits how often a code can be requested, so the endpoint can't be
-- used to spam an inbox.
CREATE TABLE IF NOT EXISTS code_requests (
  id INT PRIMARY KEY AUTO_INCREMENT,
  ip_address VARCHAR(45) NOT NULL,
  requested_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_ip_time (ip_address, requested_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Audit trail of successful logins (m0t.AUTH.6.3 — Logging and Monitoring).
CREATE TABLE IF NOT EXISTS login_log (
  id INT PRIMARY KEY AUTO_INCREMENT,
  email VARCHAR(255) NOT NULL,
  ip_address VARCHAR(45) NOT NULL,
  logged_in_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS works (
  id INT PRIMARY KEY AUTO_INCREMENT,
  brand_name VARCHAR(255) NOT NULL,
  category VARCHAR(255) NOT NULL,
  description TEXT NOT NULL,
  client_url VARCHAR(500) NULL,
  thumbnail_path VARCHAR(500) NULL,
  is_published TINYINT(1) NOT NULL DEFAULT 0,
  sort_order INT NOT NULL DEFAULT 0,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS work_images (
  id INT PRIMARY KEY AUTO_INCREMENT,
  work_id INT NOT NULL,
  image_path VARCHAR(500) NOT NULL,
  sort_order INT NOT NULL DEFAULT 0,
  FOREIGN KEY (work_id) REFERENCES works(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

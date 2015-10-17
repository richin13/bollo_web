CREATE TABLE bollo_bakery (
  bakery_id       SERIAL,
  bakery_name     VARCHAR(100) NOT NULL UNIQUE,
  bakery_state    SMALLINT     NOT NULL,
  bakery_city     VARCHAR(60)  NOT NULL,
  bakery_stock    INT                   DEFAULT 0,
  bakery_progress INT          NOT NULL DEFAULT 800,
  bakery_status   TEXT         NOT NULL DEFAULT 'Inactiva',
  CONSTRAINT bakery_PK PRIMARY KEY (bakery_id),
  CONSTRAINT state_CH CHECK (bakery_state > 0 AND bakery_state < 8)
);
CREATE TABLE bollo_production (
  production_id       SERIAL,
  production_quantity INT                      NOT NULL,
  production_date     TIMESTAMP WITH TIME ZONE NOT NULL DEFAULT (CURRENT_TIMESTAMP AT TIME ZONE 'UTC-6'),
  bakery_id           INT                      NOT NULL,
  CONSTRAINT production_PK PRIMARY KEY (production_id),
  CONSTRAINT production_bakery_FK FOREIGN KEY (bakery_id)
  REFERENCES bollo_bakery (bakery_id) ON UPDATE CASCADE
  ON DELETE CASCADE,
  CONSTRAINT valid_production_CHK CHECK (production_quantity > 0)
);
CREATE TABLE bollo_logbook (
  logbook_id          SERIAL,
  logbook_description VARCHAR(100) NOT NULL,
  logbook_date        TIMESTAMP    NOT NULL DEFAULT (CURRENT_TIMESTAMP),
  logbook_bakery      INT,
  CONSTRAINT logbook_PK PRIMARY KEY (logbook_id),
  CONSTRAINT logbook_bakery_FK FOREIGN KEY (logbook_bakery)
  REFERENCES bollo_bakery (bakery_id)
  ON UPDATE CASCADE ON DELETE CASCADE
);
CREATE TABLE bollo_logbook_general (
  logbook_general_id INT NOT NULL,
  CONSTRAINT lb_general_FK FOREIGN KEY (logbook_general_id)
  REFERENCES bollo_logbook (logbook_id)
  ON UPDATE CASCADE ON DELETE CASCADE
);
CREATE TABLE bollo_logbook_problem (
  logbook_problem_id INT   NOT NULL,
  problem_dough      FLOAT NOT NULL,
  CONSTRAINT lb_problem_FK FOREIGN KEY (logbook_problem_id)
  REFERENCES bollo_logbook (logbook_id)
  ON UPDATE CASCADE ON DELETE CASCADE
);
CREATE TABLE bollo_user (
  user_id       SERIAL UNIQUE,
  user_fname    TEXT NOT NULL,
  user_lname    TEXT NOT NULL,
  user_username TEXT NOT NULL UNIQUE,
  user_password TEXT NOT NULL,
  user_email    TEXT NOT NULL UNIQUE,
  CONSTRAINT user_PK PRIMARY KEY (user_id, user_username)
);
CREATE TABLE bollo_session (
  session_id    SERIAL,
  session_token TEXT      NULL     DEFAULT NULL UNIQUE,
  session_ip    CHAR(16)  NOT NULL,
  sess_lastlog  TIMESTAMP NOT NULL DEFAULT (CURRENT_TIMESTAMP),
  sess_user     INT,
  CONSTRAINT session_PK PRIMARY KEY (session_id),
  CONSTRAINT session_user_FK FOREIGN KEY (sess_user)
  REFERENCES bollo_user (user_id)
);
CREATE TABLE forgotten_pwds (
  fpwd_id    SERIAL,
  fpwd_token TEXT      NOT NULL UNIQUE,
  fpwd_date  TIMESTAMP NOT NULL DEFAULT (CURRENT_TIMESTAMP),
  fpwd_user  INT,
  CONSTRAINT fpwd_PK PRIMARY KEY (fpwd_id),
  CONSTRAINT fpwd_usr_FK FOREIGN KEY (fpwd_user)
  REFERENCES bollo_user (user_id)
);
CREATE TABLE bollo_manager (
  manager_id INT,
  bakery_id  INT,
  CONSTRAINT manager_PK PRIMARY KEY (manager_id, bakery_id),
  CONSTRAINT manager_usr_FK FOREIGN KEY (manager_id)
  REFERENCES bollo_user (user_id),
  CONSTRAINT manager_bakery_FK FOREIGN KEY (bakery_id)
  REFERENCES bollo_bakery (bakery_id)
);
CREATE TABLE inactive_account (
  iaccount_id               SERIAL,
  iaccount_activation_token TEXT NOT NULL UNIQUE,
  iaccount_user_id          INT  NOT NULL,
  iaccount_user             TEXT NOT NULL,
  CONSTRAINT inactive_acc_PK PRIMARY KEY (iaccount_id),
  CONSTRAINT inactive_user_FK FOREIGN KEY (iaccount_user_id, iaccount_user)
  REFERENCES bollo_user (user_id, user_username)
  ON UPDATE CASCADE ON DELETE CASCADE
);


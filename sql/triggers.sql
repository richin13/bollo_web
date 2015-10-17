CREATE OR REPLACE FUNCTION user_set_new_pw()
  RETURNS TRIGGER
AS $usnpwd$
BEGIN
  DELETE FROM forgotten_pwds
  WHERE fpwd_user = OLD.user_id;
END;
$usnpwd$ LANGUAGE PLPGSQL;

CREATE TRIGGER delete_usr_fpwd
AFTER UPDATE OF user_password ON bollo_user
EXECUTE PROCEDURE user_set_new_pw();
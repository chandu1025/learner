#ifndef VERSION_H
#define VERSION_H

struct repository;

extern const char git_version_string[];
extern const char git_built_from_commit_string[];

struct strbuf;

const char *git_user_agent(void);
const char *git_user_agent_sanitized(void);

/*
  Try to get information about the system using uname(2).
  Return -1 and put an error message into 'buf' in case of uname()
  error. Return 0 and put uname info into 'buf' otherwise.
*/
int get_uname_info(struct strbuf *buf, unsigned int full);


/*
 * Trim and replace each character with ascii code below 32 or above
 * 127 (included) using a dot '.' character.
*/
void redact_non_printables(struct strbuf *buf);

#endif /* VERSION_H */

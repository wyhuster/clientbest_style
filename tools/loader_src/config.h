

#ifndef _CONFIG_FILE_H
#define _CONFIG_FILE_H
#define MAX_PATH_LEN 512
#define MAX_FILENAME_LEN 128

extern int parse_config_file(char *flename);
extern char* get_config_var(char *varname);
void print_all_vars(void);

#endif /* _CONFIG_FILE_H*/

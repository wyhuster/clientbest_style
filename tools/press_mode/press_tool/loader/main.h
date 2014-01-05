


#ifndef _MAIN_H
#define _MAIN_H


extern int thread_num;
extern int cpu_time;
extern int cpu_num;

#define DEFAULT_CONFIG_FILENAME "loader.cfg"

extern void read_config_file(char *filename);

#ifdef __DEBUG
#define debug_printf(str,...) printf("[DEBUG: ]  "str,##__VA_ARGS__)
#else 
#define debug_printf(str,...) 
#endif

#endif    /* _MAIN_H*/

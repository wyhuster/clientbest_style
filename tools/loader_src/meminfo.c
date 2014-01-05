#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <sys/sysinfo.h>

#include "mem.h"

int get_meminfo(MemInfo *info)
{
    FILE *fd;
    int n;
    char buff[256];

//    fd = fopen("/proc/meminfo","r");
//    if(!fd){
//        printf("cannot open /proc/meminfo to read.\n");
//        return 0;
//    }
    struct sysinfo si;
    sysinfo(&si);
    info->MemTotal = si.totalram / MB;
    info->MemFree  = si.freeram / MB;
    info->MemUsed  = info->MemTotal - info->MemFree;

    info->SwapTotal = si.totalswap /MB;
    info->SwapFree  = si.freeswap /MB;
    info->SwapUsed  = info->SwapTotal - info->SwapFree;
    return 1;
}

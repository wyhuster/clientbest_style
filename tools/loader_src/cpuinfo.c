static int sysGetCpuTime (SYS_CPU_INFO_S *cpust)
{   
    FILE *fd;       
    char buff[256]; 
    SYS_CPU_INFO_S *cpu_occupy;
    cpu_occupy=cpust;

    fd = fopen("/proc/stat", "r"); 
    if(!fd)
        return ERROR;
    fgets (buff, sizeof(buff), fd);    
    sscanf (buff, "%s %u %u %u %u", 
            cpu_occupy->name, &cpu_occupy->user, &cpu_occupy->nice,
            &cpu_occupy->system, &cpu_occupy->idle);    
    fclose(fd);    
    return OK;
}

static int sysCalcCpuUsage (SYS_CPU_INFO_S *o, SYS_CPU_INFO_S *n) 
{   
    _UINT32 oTotal, nTotal;
    _UINT32 user, system;
    int cpu_use = 0;   

    oTotal = o->user + o->nice + o->system +o->idle;
    nTotal = n->user + n->nice + n->system +n->idle;

    user = n->user - o->user;
    system = n->system - o->system;

    if((nTotal-oTotal) != 0)
        cpu_use = (int)((user+system)*10000)/(nTotal-oTotal);
    else 
        cpu_use = 0;
    DBG_INFO(("sysCalcCpuUsage: cpu usage=%d\n", cpu_use));
    return cpu_use;
}

/*return usage, eg: 5230 (52.3%)*/
int sysCpuInfoGet(void)
{
    int ret = ERROR;
    SYS_CPU_INFO_S cpust1, cpust2;
    ret = sysGetCpuTime(&cpust1);
    if(ret != OK)
        return ERROR;
    sleep(2);
    sysGetCpuTime(&cpust2);
    if(ret != OK)
        return ERROR;
    return sysCalcCpuUsage(&cpust1, &cpust2);
}

bool IsSandBox()
{
unsigned char bBuffer;
unsigned long aCreateProcess = (unsigned long)GetProcAddress(GetModuleHandle("KERNEL32.dll"),"CreateProcessA");

ReadProcessMemory(GetCurrentProcess(),(void *)aCreateProcess, &bBuffer,1,0);

if(bBuffer == 0xE9)
return true;
else
return false;
}

.486
.model  flat, stdcall
option  casemap :none   ; case sensitive

uselib	MACRO	libname
	include		libname.inc
	includelib	libname.lib
ENDM

include         windows.inc
uselib	kernel32
uselib	user32
uselib	comctl32
uselib	masm32
uselib	ole32
uselib	oleaut32
uselib	advapi32
uselib	comdlg32
uselib	shell32
uselib	ufmod
include	 gdi32.inc
include	C:\masm32\macros\macros.asm
includelib	gdi32.lib
include	crc32.inc
include	WaveObject.asm
includelib winmm.lib
include 		Aboutb0x.inc	;THIS IS THE NEW PLACE OF ABOUT IT'S BETTER ;)

crc32check PROTO :DWORD,:DWORD,:DWORD,:DWORD
DlgProc     PROTO :DWORD,:DWORD,:DWORD,:DWORD
szTitle     db  'Error',0
szError     db  'An error has occured',0

.data
 Process db "builder.vmp.exe",0
  Error db "SpyEye v1.3.45 Patch",0
  szFileName db "builder.vmp.exe",0
TargetCRC32  dd 0B4946B07h ; 4DDDD880
                                           
WriteError		db			"Error writing to target process",0
red			db			"RED CReW - We do this for fun, not for profit !",0

AddressToPatch1 dd 040117Fh
ReplaceBy1 db 0E9h,083h,00h,00h,00h
ReplaceSize1 dd 5
AddressToPatch2 dd 0401184h
ReplaceBy2 db 90h
ReplaceSize2 dd 1

AddressToPatch4 dd 045FCF8h
ReplaceBy4 db 053h,070h,079h,045h,079h,065h,020h,042h,075h,069h,06Ch,064h,065h,072h,020h,076h
ReplaceSize4 dd 16
AddressToPatch5 dd 045FD08h
ReplaceBy5 db 031h,02Eh,033h,02Eh,033h,039h,020h,020h,020h,05Bh,020h,058h,079h,06Ch,069h,074h
ReplaceSize5 dd 16
AddressToPatch6 dd 045FD18h
ReplaceBy6 db 06Fh,06Ch,020h,02Fh,02Fh,020h,052h,045h,044h,020h,05Dh
ReplaceSize6 dd 11

AddressToPatch7 dd 041A91Bh
ReplaceBy7 db 90h,90h,90h,90h,90h,90h
ReplaceSize7 dd 6
AddressToPatch8 dd 041A927h
ReplaceBy8 db 090h,090h
ReplaceSize8 dd 2
AddressToPatch9 dd 041A9A3h
ReplaceBy9 db 90h,90h,90h,90h,90h,90h
ReplaceSize9 dd 6
AddressToPatch10 dd 041A9AFh
ReplaceBy10 db 90h,90h
ReplaceSize10 dd 2
AddressToPatch11 dd 041AA2Ch
ReplaceBy11 db 90h,90h,90h,90h,90h,90h
ReplaceSize11 dd 6
AddressToPatch12 dd 041AA38h
ReplaceBy12 db 90h,90h
ReplaceSize12 dd 2
AddressToPatch13 dd 041AAB5h
ReplaceBy13 db 90h,90h
ReplaceSize13 dd 2
AddressToPatch14 dd 041AABDh
ReplaceBy14 db 90h,90h
ReplaceSize14 dd 2

 Startup STARTUPINFO <>
 processinfo PROCESS_INFORMATION <>
  
.data?
hInstance   dd  ?
stWaveObj   WAVE_OBJECT <?>
xWin dd ?
hBitmap dd ?
bitmp dd ?
byteswritten dd ?

.const
icon	equ	1337
IDC_EXIT   equ     1005
IDC_PATCH1 equ 1009
IDC_ABOUT equ 1012
IDC_EDIT1013  equ 1013

.code
start:
;================ AntiDebugs ================

;	MASM32 	antiPeID example 
;			coded by ap0x
;			Reversing Labs: http://ap0x.headcoders.net

;	PeID checks OEP for signatures. If the byte pattern at OEP matches some of
;	the signatures stored in PeID.exe or userdb.txt PeID will identify target as 
;	packer or protector assigned to that signature. So we can insert any number
;	of bytes at OEP and make PeID detect the wrong packer.

;	For example this is ExeCryptor`s OEP

	db 0E8h,024h,000h,000h,000h,08Bh,04Ch,024h,00Ch,0C7h,001h,017h,000h,001h,000h,0C7h
	db 081h,0B8h,000h,000h,000h,000h,000h,000h,000h,031h,0C0h,089h,041h,014h,089h,041h
	db 018h,080h,0A1h,0C1h,000h,000h,000h,0FEh,0C3h,031h,0C0h,064h,0FFh,030h,064h,089h
	db 020h

	ASSUME FS:NOTHING
	POP FS:[0]
	ADD ESP,4
	
    invoke  GetModuleHandle, NULL
    mov hInstance, eax
    invoke  DialogBoxParam, hInstance, 101, 0, ADDR DlgProc, 0
    invoke  ExitProcess, eax
; -----------------------------------------------------------------------
DlgProc proc hWin:DWORD,uMsg:DWORD,wParam:DWORD,lParam:DWORD
LOCAL pFileMem:DWORD
LOCAL ff32:WIN32_FIND_DATA
        local   @stPs:PAINTSTRUCT,@hDc,@stRect:RECT
        local   @stBmp:BITMAP
   LOCAL hMemDC:HDC
    .if uMsg==WM_INITDIALOG
	invoke LoadIcon,hInstance,icon
	invoke SendMessage,hWin,WM_SETICON,1,eax
invoke LoadBitmap,hInstance,1
        mov hBitmap,eax
        invoke  GetDlgItem,hWin,1008
        push    hBitmap
        invoke  _WaveInit,addr stWaveObj,eax,hBitmap,30,0
        .if eax
            invoke  MessageBox,hWin,addr szError,addr szTitle,MB_OK or MB_ICONSTOP
            call    _Quit
        .else
        .endif
        pop hBitmap
        invoke  DeleteObject,hBitmap
        invoke  _WaveEffect,addr stWaveObj,1,18,4,250
    .elseif uMsg == WM_PAINT
      invoke BeginPaint,hWin,addr @stPs
      mov @hDc,eax
      invoke CreateCompatibleDC,@hDc
      mov hMemDC,eax
      invoke SelectObject,hMemDC,hBitmap
      invoke GetClientRect,hWin,addr @stRect
      invoke BitBlt,@hDc,10,10,@stRect.right,@stRect.bottom,hMemDC,0,0,MERGECOPY
      invoke DeleteDC,hMemDC
      invoke _WaveUpdateFrame,addr stWaveObj,eax,TRUE
      invoke EndPaint,hWin,addr @stPs
            xor eax,eax
            ret
    .elseif uMsg==WM_COMMAND
        mov eax,wParam
        .if eax==IDC_EXIT
            invoke SendMessage,hWin,WM_CLOSE,0,0
        .endif    
        .if eax==IDC_PATCH1
					invoke FindFirstFile,ADDR szFileName,ADDR ff32
					call InitCRC32Table
					mov pFileMem,InputFile(ADDR szFileName)
				.if eax==0
					invoke SetDlgItemText,hWin,1010,CTXT("'builder.vmp.exe' not found")
				.else
					invoke CRC32,pFileMem,ff32.nFileSizeLow
					mov edx,TargetCRC32
					.if eax != edx
					invoke SetDlgItemText,hWin,1300,CTXT("CRC32 not match")
					.else	
						invoke CreateProcess, ADDR Process, NULL, NULL, NULL, NULL, NULL, NULL, NULL, ADDR Startup, ADDR processinfo
						.if eax==0
							invoke SetDlgItemText,hWin,1010,CTXT("'builder.vmp.exe' not found")
						.else			
							invoke Sleep,800
							invoke WriteProcessMemory, processinfo.hProcess, AddressToPatch1, ADDR ReplaceBy1, ReplaceSize1, byteswritten
							invoke WriteProcessMemory, processinfo.hProcess, AddressToPatch2, ADDR ReplaceBy2, ReplaceSize2, byteswritten
							invoke WriteProcessMemory, processinfo.hProcess, AddressToPatch4, ADDR ReplaceBy4, ReplaceSize4, byteswritten
							invoke WriteProcessMemory, processinfo.hProcess, AddressToPatch5, ADDR ReplaceBy5, ReplaceSize5, byteswritten
							invoke WriteProcessMemory, processinfo.hProcess, AddressToPatch6, ADDR ReplaceBy6, ReplaceSize6, byteswritten
							invoke WriteProcessMemory, processinfo.hProcess, AddressToPatch7, ADDR ReplaceBy7, ReplaceSize7, byteswritten
							invoke WriteProcessMemory, processinfo.hProcess, AddressToPatch8, ADDR ReplaceBy8, ReplaceSize8, byteswritten
							invoke WriteProcessMemory, processinfo.hProcess, AddressToPatch9, ADDR ReplaceBy9, ReplaceSize9, byteswritten
							invoke WriteProcessMemory, processinfo.hProcess, AddressToPatch10, ADDR ReplaceBy10, ReplaceSize10, byteswritten
							invoke WriteProcessMemory, processinfo.hProcess, AddressToPatch11, ADDR ReplaceBy11, ReplaceSize11, byteswritten
							invoke WriteProcessMemory, processinfo.hProcess, AddressToPatch12, ADDR ReplaceBy12, ReplaceSize12, byteswritten
							invoke WriteProcessMemory, processinfo.hProcess, AddressToPatch13, ADDR ReplaceBy13, ReplaceSize13, byteswritten		
							invoke WriteProcessMemory, processinfo.hProcess, AddressToPatch14, ADDR ReplaceBy14, ReplaceSize14, byteswritten																	
						.endif	
					.endif
				.endif	
        .endif
        .if eax==IDC_ABOUT
        invoke DialogBoxParam, hInstance, 102, hWin, offset Aboutproc, 0
        .endif
    .elseif uMsg == WM_LBUTTONDOWN
            mov eax,lParam
            movzx   ecx,ax      ; x
            shr eax,16      ; y
            invoke  _WaveDropStone,addr stWaveObj,ecx,eax,2,256
;   .elseif uMsg== WM_MOUSEMOVE2
;           mov eax,lParam
;           movzx   ecx,ax      ; x
;           shr eax,16      ; y
;           invoke  _WaveDropStone,addr stWaveObj,ecx,eax,2,256
    .elseif uMsg == WM_CLOSE
        call    _Quit
        invoke EndDialog,xWin,0
    .elseif uMsg==WM_DESTROY
      invoke DeleteObject,hBitmap
        invoke PostQuitMessage,NULL
        .endif
    xor eax,eax
    ret
DlgProc endp
_Quit proc
invoke  _WaveFree,addr stWaveObj
invoke  DestroyWindow,xWin
invoke  PostQuitMessage,NULL
ret
_Quit endp
end start
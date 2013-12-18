@echo off
:try
del %1
if exist %1 goto try
del %2

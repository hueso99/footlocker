
Herman Group - http://www.hermangroup.org
------------------------------------------------------------------------

Hammer Binder v2.0 [Standard Edition]
Coder: Vito

release notes
-----------------------

feel free to report me bugs & Suggestions to:

 - vito@hermangroup.org

                 OR

 - freeman@hermangroup.org.

we count on your reports, they will be helpfull to fix bugs and add more features.

also i hv made a bugtrack forum for hammer binder at http://www.hermangroup.org/forums
you're welcome to register at our forums and post bugs/questions about hammer binder.

files list:
---------------
1. HammerStd20.exe
2. unicows.dll (only for win9x & Me)
3. readme.txt (the file you're reading right now).

what's new:
------------------
Now Hammer Binder v2.0 introduces Named actions & Dynamic actions.

Named Actions: you can give actions unique names. this will make it easy for other actions to refer to a specific action using it's name.

why duplicate your action,. just call it using the new Action CALL.

Dynamic Actions: now all actions supports wildcards anywhere within their bodies.
thus you can create actions with multiple functionality. dynamic actions cannot be executed because they need parameters to be substituted with wildcards.

the new action CALLPARAM let you call another action and supply its parameters.

also provided a standalone stub.

new actions:
-------------------
-Stealth DLL loader: DLLs can be binded and loaded without extraction to disk. (thanks Aphex).
-Repeat Action: repeats a specific action N times,. passing the loop variable each time as a parameter to the called action.
-Call Action.
-CallParam Action.


compatibility issues
------------------------------

* win9x users should have unicows.dll in the same folder as hammer binder.

* no special requirement for all other Operating Systems.


Best Regards,
Vito, hermangroup.

Special Thanks to Aphex and Freeman.!



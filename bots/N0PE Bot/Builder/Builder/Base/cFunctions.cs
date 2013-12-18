using System;

namespace Builder
{
    /* Copyright © 2010 w!cked */

    internal class cFunctions
    {
        public static string genString(int iLen)
        {
            Random rRand = new Random();
            string sBuffer = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
            string sResult = string.Empty;

            for (int i = 0; i < iLen; i++)
            {
                sResult += sBuffer.Substring(rRand.Next(0, sBuffer.Length), 1);
            }

            return sResult;
        }
    }
}

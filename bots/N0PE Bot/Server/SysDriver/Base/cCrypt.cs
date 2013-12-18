using System;
using System.Text;

namespace SysDriver
{
    /* Copyright © 2010 w!cked */

    internal class cCrypt
    {
        public static void RC4(ref byte[] bData, string sKey)
        {
            byte[] bKey = Encoding.Default.GetBytes(sKey);
            byte[] s = new Byte[256];
            byte[] k = new Byte[256];
            byte bTemp;
            int i, j;

            for (i = 0; i < 256; i++)
            {
                s[i] = (byte)i;
                k[i] = bKey[i % bKey.GetLength(0)];
            }

            j = 0;
            for (i = 0; i < 256; i++)
            {
                j = (j + s[i] + k[i]) % 256;
                bTemp = s[i];
                s[i] = s[j];
                s[j] = bTemp;
            }

            i = j = 0;
            for (int x = 0; x < bData.GetLength(0); x++)
            {
                i = (i + 1) % 256;
                j = (j + s[i]) % 256;
                bTemp = s[i];
                s[i] = s[j];
                s[j] = bTemp;
                int t = (s[i] + s[j]) % 256;
                bData[x] ^= s[t];
            }
        }
    }
}

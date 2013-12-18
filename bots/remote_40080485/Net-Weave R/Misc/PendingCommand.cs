using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace Net_Weave_R.Misc
{
    class PendingCommand
    {
        public int Header;
        public byte[] Data;
        public string UID;

        public PendingCommand(int header, byte[] data)
        {
            Header = header;
            Data = data;
            UID = Guid.NewGuid().ToString();
        }
    }
}

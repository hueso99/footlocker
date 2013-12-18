using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using NetLib.Misc;

namespace Net_Weave_R.Core
{
    class BaseChatPacket
    {
        public ChatClient.Header Header;
        public byte[] Data;
        public byte[] GetBytes()
        {
            List<byte> bytes = new List<byte>();
            bytes.AddRange(BitConverter.GetBytes((int)Header));
            bytes.AddRange(Data);
            byte[] packet = bytes.ToArray();
            bytes.Clear();
            bytes = null;
            return Encryption.Encrypt(packet, true);
        }
        public BaseChatPacket(ChatClient.Header header, byte[] data)
        {
            Header = header;
            Data = data;
        }
    }
}

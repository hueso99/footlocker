using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace Net_Weave_R
{
    class EventLogger
    {
        public static void LogEvent(string _event, string des)
        {
            if (EventLogged != null)
            {
                EventLogged(null, new EventLoggerEventArgs(_event, des));
            }
        }
        public static event EventHandler<EventLoggerEventArgs> EventLogged;
    }
    class EventLoggerEventArgs : EventArgs
    {
        public string Event;
        public string Description;
        public DateTime Time;
        public EventLoggerEventArgs(string _event, string des)
        {
            Event = _event;
            Description = des;
            Time = DateTime.Now;
        }
    }
}

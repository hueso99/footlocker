using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading;

namespace Net_Weave_R.Misc
{
    class FloodTimer
    {
        static Thread t;
        static TimeSpan Time;

        public static event EventHandler TimerStarted;
        public delegate void FloodTimerChangedEventHandler(TimeSpan remaining);
        public static event FloodTimerChangedEventHandler TimerChanged;
        public static event EventHandler TimerAborted;
        public static event EventHandler TimerFinished;

        public static bool Running = false;
        public static void StartTimer(TimeSpan time)
        {
            if (t != null && t.IsAlive)
                t.Abort();
            Time = time;
            Running = true;
            t = new Thread(delegate()
                {
                    TimerStarted(null, null);
                    while (Time > TimeSpan.Zero)
                    {
                        Time -= TimeSpan.FromSeconds(1.0);
                        if (TimerChanged != null)
                            TimerChanged(Time);
                        Thread.Sleep(1000);
                    }
                    TimerFinished(null, null);
                    Running = false;
                });
            t.Start();
        }

        public static void StopTimer()
        {
            if (t != null && t.IsAlive)
            {
                t.Abort();
                t = null;
                Running = false;
                TimerAborted(null, null);
            }
        }
    }
}

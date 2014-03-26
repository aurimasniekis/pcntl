<?php
/*
 * This file is part of the pcntl package.
 *
 * (c) Aurimas Niekis <aurimas.niekis@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Morker\Pcntl;

/**
 * Class Pcntl
 *
 * Process Control support in PHP implements the Unix style of process creation, program execution,
 * signal handling and process termination. Process Control should not be enabled within a web server environment and
 * unexpected results may happen if any Process Control functions are used within a web server environment.
 *
 * @author  Aurimas Niekis <aurimas.niekis@gmail.com>
 * @package Morker\Pcntl
 */
class Pcntl
{
    /**
     * Set an alarm clock for delivery of a signal
     *
     * Creates a timer that will send a SIGALRM signal to the process after the given number of seconds.
     * Any call to alarm() will cancel any previously set alarm.
     *
     * @param int $seconds The number of seconds to wait. If seconds is zero, no new alarm is created.
     *
     * @return int The time in seconds that any previously scheduled alarm had remaining before it was to be delivered, or 0 if there was no previously scheduled alarm.
     */
    public function alarm($seconds)
    {
        return pcntl_alarm($seconds);
    }

    /**
     * Alias of strerror
     *
     * This function is an alias of: $this->strerror()
     */
    public function errno($errNo)
    {
        return $this->strerror($errNo);
    }

    /**
     * Executes specified program in current process space
     *
     * @param string $path The path to a binary executable or a script with a valid path pointing to an executable in the shebang
     * @param array  $args Array of argument strings passed to the program.
     * @param array  $env  Array of strings which are passed as environment to the program
     *
     * @return null|bool Returns FALSE on error and does not return on success.
     */
    public function exec($path, array $args = array(), array $env = array())
    {
        pcntl_exec($path, $args, $env);
    }

    /**
     * Forks the currently running process
     *
     * The fork() function creates a child process that differs from the parent process only in its PID and PPID.
     * Please see your system's fork(2) man page for specific details as to how fork works on your system.
     *
     * On success, the PID of the child process is returned in the parent's thread of execution,
     * and a 0 is returned in the child's thread of execution. On failure,
     * a -1 will be returned in the parent's context, no child process will be created, and a PHP error is raised.
     *
     * @return int
     */
    public function fork()
    {
        return pcntl_fork();
    }

    /**
     * Retrieve the error number set by the last pcntl function which failed
     *
     * @return int Returns error code.
     */
    public function getLastError()
    {
        return pcntl_get_last_error();
    }

    /**
     * Get the priority of any process
     *
     * getpriority() gets the priority of pid.
     * Because priority levels can differ between system types and kernel versions,
     * please see your system's getpriority(2) man page for specific details.
     *
     * @param int $pid               If not specified, the pid of the current process is used.
     * @param int $processIdentifier One of PRIO_PGRP, PRIO_USER or PRIO_PROCESS.
     *
     * @return int The priority of the process or FALSE on error. A lower numerical value causes more favorable scheduling.
     */
    public function getPriority($pid = null, $processIdentifier = PRIO_PROCESS)
    {
        if (is_null($pid)) {
            $pid = getmypid();
        }

        return pcntl_getpriority($pid, $processIdentifier);
    }

    /**
     * Change the priority of any process
     *
     *
     *
     * @param int $priority          Generally a value in the range -20 to 20. The default priority is 0 while a lower numerical value causes more favorable scheduling.
     * @param int $pid               If not specified, the pid of the current process is used.
     * @param int $processIdentifier One of PRIO_PGRP, PRIO_USER or PRIO_PROCESS.
     *
     * @return bool TRUE on success or FALSE on failure.
     */
    public function setPriority($priority, $pid = null, $processIdentifier = PRIO_PROCESS)
    {
        return pcntl_setpriority($priority, $pid, $processIdentifier);
    }

    /**
     * Calls signal handlers for pending signals
     *
     * signalDispatch() function calls the signal handlers installed by signal() for each pending signal.
     *
     * @return bool Returns TRUE on success or FALSE on failure.
     */
    public function signalDispatch()
    {
        return pcntl_signal_dispatch();
    }

    /**
     *  Installs a signal handler
     *
     * signal() function installs a new signal handler or replaces the current signal handler for the signal indicated by signo.
     *
     * @param int          $sigNo           The signal number.
     * @param callable|int $handler         The signal handler. This may be either a callable, which will be invoked to handle the signal, or either of the two global constants SIG_IGN or SIG_DFL, which will ignore the signal or restore the default signal handler respectively.
     * @param bool         $restartSysCalls Specifies whether system call restarting should be used when this signal arrives.
     *
     * @return bool Returns TRUE on success or FALSE on failure.
     */
    public function signal($sigNo, $handler, $restartSysCalls = true)
    {
        return pcntl_signal($sigNo, $handler, $restartSysCalls);
    }

    /**
     *  Sets and retrieves blocked signals
     *
     * sigProcMask() function adds, removes or sets blocked signals, depending on the how parameter.
     *
     * @param int   $how    Sets the behavior of pcntl_sigprocmask(). Possible values: SIG_BLOCK, SIG_UNBLOCK, SIG_SETMASK
     * @param array $set    List of signals.
     * @param array $oldSet The oldset parameter is set to an array containing the list of the previously blocked signals.
     *
     * @return bool Returns TRUE on success or FALSE on failure.
     */
    public function sigProcMask($how, array $set, array $oldSet = array())
    {
        return pcntl_sigprocmask($how, $set, $oldSet);
    }

    /**
     * Waits for signals, with a timeout
     *
     * sigTimedWait() function operates in exactly the same way as sigwaitinfo() except that it takes two additional parameters,
     * seconds and nanoseconds, which enable an upper bound to be placed on the time for which the script is suspended.
     *
     * @param array $set         Array of signals to wait for.
     * @param array $sigInfo     The siginfo is set to an array containing informations about the signal. See pcntl_sigwaitinfo().
     * @param int   $seconds     Timeout in seconds.
     * @param int   $nanoseconds Timeout in nanoseconds.
     *
     * @return int  On success, pcntl_sigtimedwait() returns a signal number.
     */
    public function sigTimedWait(array $set, array $sigInfo, $seconds = 0, $nanoseconds = 0)
    {
        return pcntl_sigtimedwait($set, $sigInfo, $seconds, $nanoseconds);
    }

    /**
     * Waits for signals
     *
     * sigWaitInfo() function suspends execution of the calling script until one of the signals given in set are delivered.
     * If one of the signal is already pending (e.g. blocked by sigProcMask()), sigWaitInfo() will return immediately.
     *
     * @param array $set     Array of signals to wait for.
     * @param array $siginfo The siginfo parameter is set to an array containing informations about the signal.
     *
     * @return int On success, pcntl_sigwaitinfo() returns a signal number.
     */
    public function sigWaitInfo(array $set, array $siginfo)
    {
        return pcntl_sigwaitinfo($set, $siginfo);
    }

    /**
     * Retrieve the system error message associated with the given errno
     *
     * @param int $errNo Error Number
     *
     * @return string|bool Returns error description on success or FALSE on failure.
     */
    public function strError($errNo)
    {
        return pcntl_strerror($errNo);
    }

    /**
     * Waits on or returns the status of a forked child
     *
     * The wait function suspends execution of the current process until a child has exited, or until a signal is
     * delivered whose action is to terminate the current process or to call a signal handling function.
     * If a child has already exited by the time of the call (a so-called "zombie" process), the function returns
     * immediately. Any system resources used by the child are freed. Please see your system's wait(2) man page for
     * specific details as to how wait works on your system.
     *
     * @param int $status  pcntl_wait() will store status information in the status parameter
     * @param int $options If wait3 is available on your system (mostly BSD-style systems), you can provide the optional options parameter
     *
     * @return int the process ID of the child which exited, -1 on error or zero if WNOHANG was provided as an option (on wait3-available systems) and no child was available.
     */
    public function wait($status, $options = 0)
    {
        return pcntl_wait($status, $options);
    }

    /**
     * Waits on or returns the status of a forked child
     *
     * Suspends execution of the current process until a child as specified by the pid argument has exited,
     * or until a signal is delivered whose action is to terminate the current process or to call a
     * signal handling function.
     *
     * If a child as requested by pid has already exited by the time of the call (a so-called "zombie" process),
     * the function returns immediately. Any system resources used by the child are freed. Please see your system's
     * waitpid(2) man page for specific details as to how waitpid works on your system.
     *
     * @param int $pid     The Process ID
     * @param int $status  pcntl_waitpid() will store status information in the status parameter which can be evaluated using the following functions
     * @param int $options The value of options is the value of zero or more of the following two global constants OR'ed together:
     *
     * @return int returns the process ID of the child which exited, -1 on error or zero if WNOHANG was used and no child was available
     */
    public function waitPid($pid, $status, $options = 0)
    {
        return pcntl_waitpid($pid, $status, $options);
    }

    /**
     * Returns the return code of a terminated child
     *
     * Returns the return code of a terminated child. This function is only useful if wIfExited() returned TRUE.
     *
     * @param int $status The status parameter is the status parameter supplied to a successful call to pcntl_waitpid().
     *
     * @return int Returns the return code, as an integer.
     */
    public function wExitStatus($status)
    {
        return pcntl_wexitstatus($status);
    }

    /**
     * Checks if status code represents a normal exit
     *
     * Checks whether the child status code represents a normal exit.
     *
     * @param int $status The status parameter is the status parameter supplied to a successful call to pcntl_waitpid().
     *
     * @return bool Returns TRUE if the child status code represents a normal exit, FALSE otherwise.
     */
    public function wIfExited($status)
    {
        return pcntl_wifexited($status);
    }

    /**
     * Checks whether the status code represents a termination due to a signal
     *
     * @param int $status The status parameter is the status parameter supplied to a successful call to pcntl_waitpid().
     *
     * @return bool Returns TRUE if the child process exited because of a signal which was not caught, FALSE otherwise.
     */
    public function wIdSignaled($status)
    {
        return pcntl_wifsignaled($status);
    }

    /**
     * Checks whether the child process is currently stopped
     *
     * Checks whether the child process which caused the return is currently stopped;
     * this is only possible if the call to pcntl_waitpid() was done using the option WUNTRACED.
     *
     * @param int $status The status parameter is the status parameter supplied to a successful call to pcntl_waitpid().
     *
     * @return bool Returns TRUE if the child process which caused the return is currently stopped, FALSE otherwise.
     */
    public function wIfStopped($status)
    {
        return pcntl_wifstopped($status);
    }

    /**
     * Returns the signal which caused the child to stop
     *
     * Returns the number of the signal which caused the child to stop.
     * This function is only useful if pcntl_wifstopped() returned TRUE.
     *
     * @param int $status The status parameter is the status parameter supplied to a successful call to pcntl_waitpid().
     *
     * @return int Returns the signal number.
     */
    public function wStopSig($status)
    {
        return pcntl_wstopsig($status);
    }

    /**
     * Returns the signal which caused the child to terminate
     *
     * Returns the number of the signal that caused the child process to terminate.
     * This function is only useful if pcntl_wifsignaled() returned TRUE.
     *
     * @param int $status The status parameter is the status parameter supplied to a successful call to pcntl_waitpid().
     *
     * @return int Returns the signal number, as an integer.
     */
    public function wTermSig($status)
    {
        return pcntl_wtermsig($status);
    }
}

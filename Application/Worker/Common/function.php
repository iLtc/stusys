<?php
function workerHead(){
    isWorker();

    return array(
        'account' => deWorkerCookie()
    );
}
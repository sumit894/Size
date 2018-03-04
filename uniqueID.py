import math
import hashlib
import time
import sys

def tracker(userEmail):
    timeStr = str(time.time())
    uniqStr = userEmail + timeStr
    m = hashlib.md5()
    m.update(uniqStr)
    return m.hexdigest()

userEmail = sys.argv[1]
print tracker(userEmail)


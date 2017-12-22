import tweepy
import sys


if len(sys.argv) < 6:
	print "post_tweet.py <consumer_key> <consumer_secret> <access_token> <access_token_secret> <message>"
	sys.exit()

consumer_key = sys.argv[1]
consumer_secret = sys.argv[2]
access_token = sys.argv[3]
access_token_secret = sys.argv[4]
message = sys.argv[5]



def get_api(cfg):
  auth = tweepy.OAuthHandler(cfg['consumer_key'], cfg['consumer_secret'])
  auth.set_access_token(cfg['access_token'], cfg['access_token_secret'])
  return tweepy.API(auth)

def main():
  # Application(pr3dator) already created & access tokens already generated.
  #cfg = { 
  # "consumer_key"        : "2LBfU92Zx7VIdQUCdZnrYzrls",
  #  "consumer_secret"     : "MBf9UbUcspufxOpQkoKDbo6cfrC7x8i31zEMFaMyssMnIT8Kwh",
  #  "access_token"        : "928498344372068352-WQM02att19mpIn08XJ5k0Ie9V2kK86Z",
  #  "access_token_secret" : "2UNO5vmNVK8tVLvirSRO7SbbWX6LT3KLVMM7mA9QGysyP" 
  #  }

  cfg = { 
	"consumer_key"        : consumer_key,
	"consumer_secret"     : consumer_secret,
	"access_token"        : access_token,
    "access_token_secret" : access_token_secret 
    }
  
  
  api = get_api(cfg)
  tweet = message
  status = api.update_status(status=tweet) 
  # Status : Posts tweets on your twitter profile

if __name__ == "__main__":
  main()

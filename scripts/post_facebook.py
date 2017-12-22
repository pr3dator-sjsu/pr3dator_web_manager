import facebook
import sys

if len(sys.argv) < 4:
	print "post_wall.py <page_id> <access_token> <message>"
	sys.exit()

page_id = sys.argv[1]
access_token = sys.argv[2]
msg = sys.argv[3]


def main():
  # Fill in the values noted in previous steps here
  # cfg = {
  # "page_id"      : "2043976655826181",  # Step 1
  # "access_token" : "EAAcZB224ahyEBAPMd7l4O7JWnCiJ2DF8vlTgHDkve7YoFm2mLuZBBb0qI0ZCV3wQKDb1ZC6dmaQxFIYV7ZA4XxH80xPUom5X8LFZBeQYFX9NoEcPnki3En4ZCkWDoJR4EtUn9V2rtaYhqBFr5xLIrxHUOAzfgrEDOSz2iUfgd9X27ce04pZCLdzjT2QPQliZBGMvQ96q2xF86cAZDZD"   # Step 3
#    }


	cfg = {
	    "page_id"      : page_id,  # Step 1
	    "access_token" : access_token  # Step 3
        }


	api = get_api(cfg)
 	#msg = "Hello, world!"
	status = api.put_wall_post(msg)

def get_api(cfg):
  graph = facebook.GraphAPI(cfg['access_token'])
  # Get page token to post as the page. You can skip 
  # the following if you want to post as yourself. 
  resp = graph.get_object('me/accounts')
  page_access_token = None
  for page in resp['data']:
    if page['id'] == cfg['page_id']:
      page_access_token = page['access_token']
  graph = facebook.GraphAPI(page_access_token)
  return graph
  # You can also skip the above if you get a page token:
  # http://stackoverflow.com/questions/8231877/facebook-access-token-for-pages
  # and make that long-lived token as in Step 3

if __name__ == "__main__":
  main()
